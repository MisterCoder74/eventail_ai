<?php
/**
 * Script PHP per caricare una conversazione condivisa tramite shareToken
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use GET.']);
    exit();
}

try {
    $shareToken = $_GET['shareToken'] ?? null;

    if (!$shareToken) {
        throw new Exception('shareToken parameter is required');
    }

    $directory = __DIR__ . '/requests';
    if (!is_dir($directory)) {
        throw new Exception('Requests directory not found');
    }

    // Cerca in tutti i file di conversazioni
    $files = glob($directory . '/conversations_*.json');

    if ($files === false) {
        throw new Exception('Failed to read directory');
    }

    // Filtra il file "latest"
    $files = array_filter($files, function($file) {
        return basename($file) !== 'conversations_latest.json';
    });

    // Ordina per data (più recenti prima)
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    // Cerca la conversazione con il shareToken
    $foundConversation = null;
    $sourceFile = null;

    foreach ($files as $file) {
        $content = file_get_contents($file);
        if ($content === false) {
            continue;
        }

        $conversations = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($conversations)) {
            continue;
        }

        foreach ($conversations as $conv) {
            if (isset($conv['shareToken']) && $conv['shareToken'] === $shareToken) {
                $foundConversation = $conv;
                $sourceFile = basename($file);
                break 2;
            }
        }
    }

    // Se non trovato, controlla anche nel file latest
    if (!$foundConversation) {
        $latestFile = $directory . '/conversations_latest.json';
        if (file_exists($latestFile)) {
            $content = file_get_contents($latestFile);
            if ($content !== false) {
                $conversations = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($conversations)) {
                    foreach ($conversations as $conv) {
                        if (isset($conv['shareToken']) && $conv['shareToken'] === $shareToken) {
                            $foundConversation = $conv;
                            $sourceFile = 'conversations_latest.json';
                            break;
                        }
                    }
                }
            }
        }
    }

    if (!$foundConversation) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'Conversation not found with this share token'
        ]);
        exit();
    }

    // Ritorna la conversazione trovata
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'conversation' => $foundConversation,
        'source_file' => $sourceFile
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'conversation' => null
    ]);
    error_log('Load shared conversation error: ' . $e->getMessage());
}
?>
