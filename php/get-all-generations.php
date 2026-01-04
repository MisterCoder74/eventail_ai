<?php
header('Content-Type: application/json');

// Percorso sul filesystem (legge i file)
$dir = __DIR__ . '/../cardimages';

// Percorso URL (relativo al file PHP)
$baseUrl = dirname($_SERVER['SCRIPT_NAME']) . '/../cardimages/';
// Normalizziamo eventuali doppie barre
$baseUrl = preg_replace('#/+#','/',$baseUrl);

if (!is_dir($dir)) {
echo json_encode(['success' => true, 'generations' => []]);
exit;
}

$generations = [];
$jsonFiles = glob($dir . '/*.json');

foreach ($jsonFiles as $jsonFile) {
$content = file_get_contents($jsonFile);
$metadata = json_decode($content, true);

if ($metadata && isset($metadata['filename'])) {
$imagePath = $dir . '/' . $metadata['filename'];
if (file_exists($imagePath)) {
$generations[] = [
'filename' => $metadata['filename'],
'url' => $baseUrl . $metadata['filename'],
'timestamp' => $metadata['timestamp'],
'prompt' => $metadata['prompt'],
'size_bytes' => $metadata['size_bytes'],
'size_human' => $metadata['size_human']
];
}
}
}

usort($generations, fn($a, $b) => strtotime($b['timestamp']) - strtotime($a['timestamp']));

echo json_encode(['success' => true, 'generations' => $generations]);
?>
