<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flushing local files</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<!-- Check if local files should be flushed -->
<?php 

    $dir = 'uploads/';
    $files = scandir($dir);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['flush'])) {
        if ($_GET['flush'] === '1') {
            #$files = glob('uploads/*'); // Get all files in the uploads directory
            foreach ($files as $file) {
                if (is_file($dir . $file)) {
                    unlink($dir . $file); // Delete the file
                    echo '<p style="color: red; font-weight: bold; text-align: center;">Deleted file: ' . htmlspecialchars($file, ENT_QUOTES, 'UTF-8') . '</p>';
                }
            }
        }
        echo '<p style="color: green; font-weight: bold; text-align: center;">All local files have been flushed.</p>';
    }
    else {
        echo '<p style="color: red; font-weight: bold; text-align: center;">Failed to flush local files.</p>';
    }
?>

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
        <a href="index.php"><button aria-setsize="50">Back to Upload Page</button></a>
    </div>

</body>
</html>