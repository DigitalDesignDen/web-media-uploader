<?php
// Define maximum file size (50MB)
$maxFileSize = 50 * 1024 * 1024;
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$uploadDir = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $files = $_FILES['image'];
    $fileCount = is_array($files['name']) ? count($files['name']) : 0;
    $uploaded = false;

    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = basename($files['name'][$i]);
        $fileType = $files['type'][$i];
        $tmpName = $files['tmp_name'][$i];
        $fileSize = $files['size'][$i];
        $error = $files['error'][$i];
        

        if ($error === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        if ($error !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds the server limit (upload_max_filesize). Maximum: ' . ini_get('upload_max_filesize'),
                UPLOAD_ERR_FORM_SIZE => 'File exceeds the form limit (MAX_FILE_SIZE).',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Temporary folder missing.',
                UPLOAD_ERR_CANT_WRITE => 'Cannot write to disk.',
                UPLOAD_ERR_EXTENSION => 'File upload blocked by extension.'
            ];
            echo "Upload failed for $fileName: " . ($errorMessages[$error] ?? 'Unknown error') . "<br>\n";
            continue;
        }

        if ($fileSize > $maxFileSize) {
            echo "File '$fileName' is too large. Maximum size: " . ($maxFileSize / (1024 * 1024)) . "MB. Your file: " . round($fileSize / (1024 * 1024), 2) . "MB<br>\n";
            continue;
        }

        if (!in_array($fileType, $allowedTypes)) {
            echo "Only image files (JPG, JPEG, PNG, GIF, WebP) are allowed for '$fileName'.<br>\n";
            continue;
        }

        #$uniqueName = uniqid('', true) . '_' . $fileName;
        $uniqueName = $fileName;
        $uploadPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            echo "Image '$fileName' uploaded successfully!<br>\n";
            echo "<img src='$uploadPath' alt='Uploaded image' style='max-width: 300px; display: block; margin-bottom: 1rem;'>\n";
            $uploaded = true;
        } else {
            echo "Failed to move uploaded file '$fileName'.<br>\n";
        }
    }

    if (!$uploaded) {
        echo "No files were uploaded successfully.";
    }
} else {
    echo "No files uploaded.";
}
?>

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
        <a href="index.php"><button aria-setsize="50">Back to Upload Page</button></a>
    </div>