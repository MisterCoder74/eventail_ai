<?php
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
$directory = __DIR__ . '/requests';
if (!is_dir($directory)) {
throw new Exception('Requests directory not found');
}

$timestamp = $_GET['timestamp'] ?? null;
$filename = $directory . ($timestamp
? "/conversations_{$timestamp}.json"
: '/conversations_latest.json');

if (!file_exists($filename)) {
throw new Exception('Conversations file not found');
}

$jsonData = file_get_contents($filename);
if ($jsonData === false) {
throw new Exception('Failed to read file');
}

$conversations = json_decode($jsonData, true);
if (json_last_error() !== JSON_ERROR_NONE) {
throw new Exception('Invalid JSON: ' . json_last_error_msg());
}

// Ogni oggetto mantiene eventuale campo imageUrl
echo json_encode([
'success' => true,
'conversations' => $conversations,
'count' => count($conversations),
'filename' => basename($filename),
'loaded_at' => date('Y-m-d H:i:s')
]);
} catch (Exception $e) {
http_response_code(404);
echo json_encode([
'success' => false,
'error' => $e->getMessage(),
'conversations' => []
]);
error_log('Load conversations error: ' . $e->getMessage());
}
?>
