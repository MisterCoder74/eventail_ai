<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['imageData'])) {
    echo json_encode(['success' => false, 'error' => 'Nessun dato immagine ricevuto']);
    exit;
}

$imageData = $input['imageData'];
$prompt = $input['prompt'] ?? '';
$timestamp = $input['timestamp'] ?? date('c');

$decoded = base64_decode($imageData);
if (!$decoded) {
    echo json_encode(['success' => false, 'error' => 'Base64 non valida']);
    exit;
}

$dir = dirname(__DIR__) . '/cardimages';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$filename = 'img_' . uniqid() . '.png';
$filepath = $dir . '/' . $filename;

// Save image
file_put_contents($filepath, $decoded);
$sizeBytes = filesize($filepath);

// Save metadata JSON
$metadata = [
    'filename' => $filename,
    'timestamp' => $timestamp,
    'prompt' => $prompt,
    'size_bytes' => $sizeBytes,
    'size_human' => formatBytes($sizeBytes)
];

$jsonFilename = str_replace('.png', '.json', $filename);
$jsonFilepath = $dir . '/' . $jsonFilename;
file_put_contents($jsonFilepath, json_encode($metadata, JSON_PRETTY_PRINT));

echo json_encode([
    'success' => true,
    'filepath' => 'cardimages/' . $filename
]);

function formatBytes($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>
