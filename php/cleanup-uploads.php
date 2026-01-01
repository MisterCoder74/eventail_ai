<?php
header('Content-Type: application/json');

$dir = dirname(__DIR__) . '/uploads';

// Create uploads directory if it doesn't exist
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
    echo json_encode([
        'success' => true,
        'deletedCount' => 0,
        'newSize' => 0,
        'message' => 'Uploads directory created'
    ]);
    exit;
}

$maxSizeBytes = 500 * 1024 * 1024; // 500MB
$deletedCount = 0;
$iterations = 0;
$maxIterations = 50; // Prevent infinite loops

// Calculate initial size
function getDirectorySize($dir) {
    $size = 0;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $path = $dir . '/' . $file;
        if (is_file($path)) {
            $size += filesize($path);
        }
    }
    return $size;
}

$currentSize = getDirectorySize($dir);

// Delete files in FIFO order (oldest first) until under 500MB
while ($currentSize > $maxSizeBytes && $iterations < $maxIterations) {
    // Get all files with their modification times
    $files = [];
    $iterator = new DirectoryIterator($dir);
    
    foreach ($iterator as $fileInfo) {
        if ($fileInfo->isFile() && !$fileInfo->isDot()) {
            $files[] = [
                'path' => $fileInfo->getPathname(),
                'mtime' => $fileInfo->getMTime(),
                'size' => $fileInfo->getSize()
            ];
        }
    }
    
    if (empty($files)) {
        break;
    }
    
    // Sort by modification time (oldest first)
    usort($files, function($a, $b) {
        return $a['mtime'] - $b['mtime'];
    });
    
    // Delete up to 10 oldest files
    $filesToDelete = array_slice($files, 0, min(10, count($files)));
    
    foreach ($filesToDelete as $file) {
        if (file_exists($file['path'])) {
            if (unlink($file['path'])) {
                $currentSize -= $file['size'];
                $deletedCount++;
            }
        }
    }
    
    $iterations++;
}

// Recalculate final size
$finalSize = getDirectorySize($dir);

echo json_encode([
    'success' => true,
    'deletedCount' => $deletedCount,
    'initialSize' => formatBytes($currentSize + ($deletedCount > 0 ? ($deletedCount * 100000) : 0)), // Approximate
    'finalSize' => formatBytes($finalSize),
    'iterations' => $iterations
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
