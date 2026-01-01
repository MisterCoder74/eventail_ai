<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['imageData'])) {
echo json_encode(['success' => false, 'error' => 'Nessun dato immagine ricevuto']);
exit;
}

$imageData = $input['imageData'];
$decoded = base64_decode($imageData);
if (!$decoded) {
echo json_encode(['success' => false, 'error' => 'Base64 non valida']);
exit;
}

$dir = __DIR__ . '/cardimages';
if (!is_dir($dir)) {
mkdir($dir, 0777, true);
}

$filename = 'img_' . uniqid() . '.png';
$filepath = $dir . '/' . $filename;
file_put_contents($filepath, $decoded);

echo json_encode([
'success' => true,
'filepath' => 'cardimages/' . $filename
]);
?>