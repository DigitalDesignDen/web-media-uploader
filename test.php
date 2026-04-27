<?php

$dirs = array('uploads/', '.', '/mnt/nas/2026/');
foreach ($dirs as $dir) {
    $files = scandir($dir);

    $count = 0;
    echo '<h2 style="font-family: monospace;">Found Images in ' . $dir . '</h2>';
    echo '<table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse;">';
    foreach ($files as $img) {

        if ($count++ % 3 === 0) {
            echo '<tr>';
        }
            echo '<th style="border: 2px solid #fda500; padding: 8px;">' . $img . '</th>';
            #echo '<th style="border: 2px solid #8700bd; padding: 2px;"><img src="uploads/' . $img . '" style="max-width: 115px; display: block; margin-bottom: 1rem;"></th>';
        if ($count % 3 === 0) {
            echo '</tr>';
        }
    }
}

if (is_dir('/mnt/nas/2026/')) {
    echo '<p style="color: green; font-weight: bold;">Directory /mnt/nas/2026/ is accessible.</p>';
/*    if ( file_put_contents('/mnt/nas/2026/test.txt', 'hello') ) {
        echo '<p style="color: green; font-weight: bold;">Successfully written to /mnt/nas/2026/test.txt</p>';
    } else {
        echo '<p style="color: red; font-weight: bold;">UnSuccessfully written to /mnt/nas/2026/test.txt</p>';
    }*/
#        unlink('/mnt/nas/2026/test.txt');
#    mkdir('/mnt/nas/2026/test', 0600, true);
copy('uploads/69e2bcd59ecf74.99349273_tree.jpg', '/mnt/nas/2026/test/test.jpg');
} else {
    echo '<p style="color: red; font-weight: bold;">Directory /mnt/nas/2026/ is NOT accessible.</p>';
}


#file_put_contents('/mnt/nas/2026/test.txt', 'hello');
#copy('uploads/69e2bcd59ecf74.99349273_tree.jpg', '/mnt/nas/2026/test.jpg');


?>