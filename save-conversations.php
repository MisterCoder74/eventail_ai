<?php
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
$conversations = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
throw new Exception('Invalid JSON data: ' . json_last_error_msg());
}
if (!is_array($conversations)) {
throw new Exception('Expected array of conversations');
}

$directory = __DIR__ . '/requests';
if (!is_dir($directory)) {
mkdir($directory, 0755, true);
}

$timestamp = date('Y-m-d_H-i-s');
$filename = $directory . '/conversations_' . $timestamp . '.json';

// Salva anche eventuali campi "imageUrl" così com’è
$jsonData = json_encode($conversations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($filename, $jsonData) === false) {
throw new Exception('Failed to write file');
}

// File "latest"
file_put_contents($directory . '/conversations_latest.json', $jsonData);

file_put_contents(
$directory . '/save_log.txt',
date('Y-m-d H:i:s') . " - Saved " . count($conversations) . " conversations\n",
FILE_APPEND
);

echo json_encode([
'success' => true,
'filename' => basename($filename),
'count' => count($conversations),
'timestamp' => $timestamp
]);
} catch (Exception $e) {
http_response_code(500);
echo json_encode(['success' => false, 'error' => $e->getMessage()]);
error_log('Save conversations error: ' . $e->getMessage());
}
?>