<?php
/**
 * Script PHP per listare tutti i file di conversazioni salvati
 * Utile per recuperare versioni precedenti
 */

// Headers per CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gestione preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verifica che sia una richiesta GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use GET.']);
    exit();
}

try {
    $directory = __DIR__ . '/requests';

    // Verifica che la cartella esista
    if (!file_exists($directory)) {
        throw new Exception('Requests directory not found');
    }

    // Legge tutti i file JSON nella cartella
    $files = glob($directory . '/conversations_*.json');
    
    if ($files === false) {
        throw new Exception('Failed to read directory');
    }

    // Filtra il file "latest" dalla lista principale
    $files = array_filter($files, function($file) {
        return basename($file) !== 'conversations_latest.json';
    });

    // Ordina per data (più recenti prima)
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });

    // Crea array con informazioni sui file
    $filesList = [];
    
    foreach ($files as $file) {
        $basename = basename($file);
        $filesize = filesize($file);
        $modified = filemtime($file);
        
        // Estrae il timestamp dal nome file
        preg_match('/conversations_(.+)\.json/', $basename, $matches);
        $timestamp = isset($matches[1]) ? $matches[1] : 'unknown';
        
        // Conta le conversazioni nel file
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        $conversationsCount = is_array($data) ? count($data) : 0;

        $filesList[] = [
            'filename' => $basename,
            'timestamp' => $timestamp,
            'size' => $filesize,
            'size_formatted' => formatBytes($filesize),
            'modified' => date('Y-m-d H:i:s', $modified),
            'conversations_count' => $conversationsCount
        ];
    }

    // Risposta di successo
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'files' => $filesList,
        'total_files' => count($filesList)
    ]);

} catch (Exception $e) {
    // Gestione errori
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'files' => []
    ]);
    
    error_log('List conversations error: ' . $e->getMessage());
}

/**
 * Formatta i bytes in formato leggibile
 */
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}
?>