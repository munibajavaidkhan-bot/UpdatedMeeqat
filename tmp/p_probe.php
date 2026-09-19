<?php
$c = file_get_contents(dirname(__DIR__) . '/resources/views/tryon/index.blade.php');
$needle = '        async puterImageToDataUrl(image) {';
echo 'needle with CRLF-agnostic search (plain): ' . substr_count($c, $needle) . PHP_EOL;
echo 'with CRLF: ' . substr_count($c, str_replace("\n", "\r\n", $needle)) . PHP_EOL;
$pos = strpos($c, 'async puterImageToDataUrl');
var_dump(substr($c, $pos - 12, 60));
