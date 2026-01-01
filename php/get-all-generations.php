<?php
header('Content-Type: application/json');

$dir = dirname(__DIR__) . '/cardimages';

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
        // Verify that the corresponding image file exists
        $imagePath = $dir . '/' . $metadata['filename'];
        if (file_exists($imagePath)) {
            $generations[] = [
                'filename' => $metadata['filename'],
                'url' => 'cardimages/' . $metadata['filename'],
                'timestamp' => $metadata['timestamp'],
                'prompt' => $metadata['prompt'],
                'size_bytes' => $metadata['size_bytes'],
                'size_human' => $metadata['size_human']
            ];
        }
    }
}

// Sort by timestamp descending (newest first)
usort($generations, function($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});

echo json_encode([
    'success' => true,
    'generations' => $generations
]);
?>
