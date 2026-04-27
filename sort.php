<?php
    $dir = 'uploads/';
    $files = scandir($dir);
    $count = 0;
    $exp = "/IMG_\d{8}/i";
    $fileInfo = array();
    $selectedImages = $_POST['selected_images'] ?? array();

    foreach($files as $img) {
        if ( preg_match($exp, $img, $matches) ) { 
            $timestamp = mktime(0,0,0,(int)substr($matches[0], 8, 2), (int)substr($matches[0], 10, 2), (int)substr($matches[0], 4, 4));
            $fileInfo[$img] = (int)$timestamp;
        }
    }

    arsort($fileInfo, SORT_NUMERIC);

    $timestamps = array_values($fileInfo);
?>

<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sort Media</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
        <a href="index.php"><button aria-setsize="50">Back to Upload Page</button></a>
    </div>
    <br/><hr/><br/>

    <h2 style="font-family: monospace; text-align:center">Sorted Media</h2>

<!-- Display uploaded images -->
<?php if (!empty($selectedImages)): ?>
    <div style="max-width: 600px; margin: 0 auto 20px auto; padding: 12px; border: 1px solid #8700bd; background: #f5effc;">
        <p style="font-family: monospace; margin-bottom: 8px;">Selected files submitted:</p>
<?php foreach ($selectedImages as $selectedImage): ?>
        <p style="font-family: monospace; font-weight: normal;"><?= htmlspecialchars($selectedImage, ENT_QUOTES, 'UTF-8') ?></p>
<?php endforeach; ?>
    </div>

<!-- Upload the images to the mounted NAS directiry if it is accessible -->
<?php
    if (is_dir('/mnt/nas/2026/test')) {
        foreach ($selectedImages as $selectedImage) {
                if (file_exists('uploads/' . $selectedImage)) {
                    copy('uploads/' . $selectedImage, '/mnt/nas/2026/test/' . $selectedImage);
                }
            }
    }
?>
<?php endif; ?>


    <form method="post" action="sort.php" style="width: 100%; max-width: 600px; margin: 0 auto; padding: 0; background: transparent; box-shadow: none;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse;">

<?php

    $temp_timestamp = 0;
    $new_month = false;

        foreach ($fileInfo as $img => $timestamp) {

            if (date("F Y", $timestamp) != date("F Y", $temp_timestamp)) {
                echo "\t<tr>\n";
                echo "\t\t<th colspan='3' style='border: 2px none #8700bd; padding: 2px;'>\n";
                echo "\t\t<p style='text-align: left; font-weight: bold; font-family: monospace;'>" . date("F Y", $timestamp) . "</p>\n";
                echo "\t\t</th>\n";
                echo "\t</tr>\n";
                $temp_timestamp = $timestamp;
                $new_month= true;
            }

            if ($count++ % 3 === 0 || $new_month) {
                echo "\t<tr>\n";
                $new_month = false;
            }
                $isSelected = in_array($img, $selectedImages, true);
                $cellBackground = $isSelected ? 'lightgray' : 'transparent';
                $imageWidth = $isSelected ? '120px' : '115px';
                echo "\t\t" . '<td style="border: 2px solid #8700bd; padding: 2px; background: ' . $cellBackground . ';" onclick="toggleSelection(this)">' . "\n";
                echo "\t\t\t" . '<input type="checkbox" name="selected_images[]" value="' . htmlspecialchars($img, ENT_QUOTES, 'UTF-8') . '"' . ($isSelected ? ' checked' : '') . ' hidden>' . "\n";
                echo "\t\t\t" . '<img src="uploads/' . rawurlencode($img) . '" style="max-width: ' . $imageWidth . '; display: block; margin-bottom: 1rem;">' . "\n";
                echo "\t\t\t<p>" . date("F d Y", (int)$timestamp) . "</p>\n";
                echo "\t\t</td>\n";
            if ($count % 3 === 0 || $count === count($fileInfo)) {
                echo "\t</tr>\n";
            }
        }

?>
    </table>
    <div style="max-width: 600px; margin: 20px auto 0 auto;">
        <button type="submit">Submit selected images</button>
    </div>
    </form>

    <script>
    function toggleSelection(cell) {
        const checkbox = cell.querySelector('input[type="checkbox"]');
        const image = cell.querySelector('img');

        checkbox.checked = !checkbox.checked;
        cell.style.background = checkbox.checked ? 'lightgray' : 'transparent';
        image.style.maxWidth = checkbox.checked ? '120px' : '115px';
    }
    </script>
</body>
</html>

<?php


?>
