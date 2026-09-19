<?php
$p = 'app/Http/Controllers/TryOnController.php';
$c = file_get_contents($p);
if (strpos($c, "->attach('files'") !== false) { echo "already fixed\n"; exit; }
$NL = chr(10);

$hfOldStart = strpos($c, '$uploadMultipart = function');
$marker = "->post(\$base . '/upload');";
$hfOldEnd = strpos($c, $marker, $hfOldStart) + strlen($marker);
$hfOld = substr($c, $hfOldStart, $hfOldEnd - $hfOldStart);
$hfNew = '$uploadMultipart = function (string $dataB64, string $filename, string $mime) use ($base) {' . $NL
    . '    $res = Http::timeout(60)' . $NL
    . "        ->attach('files', base64_decode(\$dataB64), \$filename, ['Content-Type' => \$mime])" . $NL
    . "        ->post(\$base . '/upload');" . $NL
    . '    $json = $res->json();' . $NL
    . '    return (is_array($json) && isset($json[0])) ? $json[0] : null;' . $NL
    . '};';
$c = str_replace($hfOld, $hfNew, $c);

$qStart = strpos($c, '$boundary = uniqid();');
$marker2 = "->post(\$base . '/gradio_api/upload');";
$qEnd = strpos($c, $marker2, $qStart) + strlen($marker2);
$qOld = substr($c, $qStart, $qEnd - $qStart);
$qNew = '$headers = [];' . $NL
    . 'if ($token) {' . $NL
    . '    $headers[\'Authorization\'] = \'Bearer \' . $token;' . $NL
    . '}' . $NL
    . '$res = Http::timeout(60)' . $NL
    . '    ->withHeaders($headers)' . $NL
    . "    ->attach('files', base64_decode(\$compositeB64), 'composite.jpg', ['Content-Type' => 'image/jpeg'])" . $NL
    . "    ->post(\$base . '/gradio_api/upload');";
$c = str_replace($qOld, $qNew, $c);

file_put_contents($p, $c);
echo "replaced OK\n";
