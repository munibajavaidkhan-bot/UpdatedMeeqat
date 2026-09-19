<?php
$file = dirname(__DIR__) . '/resources/views/tryon/index.blade.php';
$c = file_get_contents($file);
$needle = 'input_images: [this.userImage, this.selectedItem.image],';
$count = substr_count($c, $needle);
if ($count !== 1) { echo "FAIL: anchor found $count time(s)" . PHP_EOL; exit(1); }
file_put_contents($file, str_replace($needle, 'input_images: [personData, capData],', $c));
echo 'OK input_images fixed' . PHP_EOL;
