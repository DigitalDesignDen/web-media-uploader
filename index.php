<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Photo Upload Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
    <h1>Upload Your Photos</h1>
    <p>Choose one or more images to upload:</p>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image[]" accept="image/*" multiple onchange="checkFileSize(this)">
        <button type="submit" aria-setsize="50">Upload Images</button>
    </form>
</div>
<br/><hr/><br/>

<script>
function checkFileSize(input) {
    const maxSizeMB = 50;
    const maxSizeBytes = maxSizeMB * 1024 * 1024;

    if (input.files && input.files.length) {
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            if (file.size > maxSizeBytes) {
                alert('File "' + file.name + '" is too large! Maximum size: ' + maxSizeMB + 'MB. Your file: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB');
                input.value = ''; // Clear the input
                return;
            }
        }
    }
}
</script>

<h2 style="font-family: monospace;">Uploaded Images</h2>

<?php

    $dir = 'uploads/';
    $files = scandir($dir);

    $exts = array('.png', '.jpg', '.jpeg', '.gif', '.webp');
    $countDisplayed = 0;
    $countFiles = 0;

    echo '<table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse;">'."\n";
    foreach ($exts as $ext) {
        echo " \t <tr> \n";
            echo "\t\t<th colspan='3' style='border: 2px none #8700bd; padding: 2px;'>\n";
            echo "\t\t<p style='text-align: left; font-weight: bold; font-family: monospace;'>" . strtoupper(trim($ext, '.')) . " Files</p>\n";
            echo "\t\t</th>\n";
        echo "\t </tr> \n";

        foreach ($files as $img) {
            
            if ( substr_compare($img, $ext, -strlen($ext), strlen($ext)) === 0 ) {
                
                        if ($countDisplayed++ % 3 === 0) {
                            echo "\t<tr>\n";
                        }
                            #echo '<th style="border: 1px solid #6ef1d5; padding: 8px;">' . $img . '</th>';
                            echo "\t\t" . '<th style="border: 2px solid #8700bd; padding: 2px;"><img src="uploads/' . $img . '" style="max-width: 115px; display: block; margin-bottom: 1rem;">' . "\n";
                            echo "\t\t\t<p>File Size: " . filesize('uploads/' . $img) . " bytes</p>\n";
                            echo "\t\t\t<p>Content last changed: " . date("F d Y H:i:s.", filemtime('uploads/' . $img)) . "</p>\n";
                            echo "\t\t</th>\n";
                        if ($countDisplayed % 3 === 0) {
                            echo "\t</tr>\n";
                        }

            }
            $countFiles++;
            if ($countFiles === count($files)) {
                echo "\t</tr>\n";
            }
        }
    }
    echo "</table>\n";

?>

<br/><hr/><br/>
<div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
    <button onclick="window.location.href='sort.php'" aria-setsize="50">Sort Media</button>
</div>

<div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
    <button onclick="window.location.href='flush_local.php?flush=1'" aria-setsize="50">Flush all local files</button>
</div>

</body>
</html>