<?php
/**
 * Script PHP per generare tag automatici usando GPT
 * Analizza il contenuto della conversazione e genera 2-3 tag rilevanti
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST.']);
    exit();
}

try {
    $input = file_get_contents('php://input');
    $conversation = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON data: ' . json_last_error_msg());
    }

    if (!isset($conversation['messages']) || !is_array($conversation['messages'])) {
        throw new Exception('Invalid conversation data');
    }

    // Leggi API key da config.txt
    $configFile = __DIR__ . '/config.txt';
    if (!file_exists($configFile)) {
        throw new Exception('Config file not found');
    }

    $apiKey = trim(file_get_contents($configFile));
    if (empty($apiKey)) {
        throw new Exception('API key not configured');
    }

    // Prepara il contenuto della conversazione da analizzare
    $conversationText = '';
    foreach ($conversation['messages'] as $msg) {
        if ($msg['role'] !== 'system') {
            $conversationText .= $msg['role'] . ': ' . $msg['content'] . "\n\n";
        }
    }

    // Limita la lunghezza per non superare i token
    $conversationText = substr($conversationText, 0, 2000);

    // Prompt per GPT
    $prompt = "Analizza questa conversazione e genera 2-3 tag rilevanti. " .
              "I tag devono essere generici e riutilizzabili. " .
              "Usa solo questi tag se applicabili: AI, Tutorial, Brainstorming, Problem-Solving, Creative, Code, Research, Discussion, Idea, Tips, Learning, Planning, Analysis, Writing. " .
              "Rispondi solo con un array JSON senza altro testo. " .
              "\n\nConversazione:\n" . $conversationText;

    // Chiama OpenAI API
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Sei un assistente che genera tag per conversazioni. Rispondi solo con array JSON.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 100
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception('OpenAI API error: ' . $response);
    }

    $data = json_decode($response, true);
    if (!isset($data['choices'][0]['message']['content'])) {
        throw new Exception('Invalid API response');
    }

    $content = trim($data['choices'][0]['message']['content']);

    // Estrai l'array JSON dalla risposta
    if (preg_match('/\[(.*?)\]/s', $content, $matches)) {
        $tagsJson = '[' . $matches[1] . ']';
        $tags = json_decode($tagsJson, true);

        if (is_array($tags)) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'tags' => $tags
            ]);
            exit();
        }
    }

    // Se fallisce, ritorna tag di default
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'tags' => ['Discussion']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'tags' => []
    ]);
    error_log('Generate tags error: ' . $e->getMessage());
}
?>
