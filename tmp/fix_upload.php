<?php
$p = 'app/Http/Controllers/TryOnController.php';
$c = file_get_contents($p);
if (strpos($c, "->attach('files'") !== false) { echo "already fixed\n"; exit; }

$hfOldStart = strpos($c, '$uploadMultipart = function');
$hfOldEnd = strpos($c, "->post($base . '/upload');", $hfOldStart) + strlen("->post($base . '/upload');");
$hfOld = substr($c, $hfOldStart, $hfOldEnd - $hfOldStart);
$hfNew = <<<"'PHP'
\$uploadMultipart = function (string \$dataB64, string \$filename, string \$mime) use (\$base) {
    \$res = Http::timeout(60)
        ->attach('files', base64_decode(\$dataB64), \$filename, ['Content-Type' => \$mime])
        ->post(\$base . '/upload');
    \$json = \$res->json();
    return (is_array(\$json) && isset(\$json[0])) ? \$json[0] : null;
};
PHP;
$c = str_replace($hfOld, $hfNew, $c);

$qStart = strpos($c, '$boundary = uniqid();');
$qEnd = strpos($c, "->post($base . '/gradio_api/upload');", $qStart) + strlen("->post($base . '/gradio_api/upload');");
$qOld = substr($c, $qStart, $qEnd - $qStart);
$qNew = <<<"'PHP'
\$headers = [];
if (\$token) {
    \$headers['Authorization'] = 'Bearer ' . \$token;
}
\$res = Http::timeout(60)
    ->withHeaders(\$headers)
    ->attach('files', base64_decode(\$compositeB64), 'composite.jpg', ['Content-Type' => 'image/jpeg'])
    ->post(\$base . '/gradio_api/upload');
PHP;
$c = str_replace($qOld, $qNew, $c);

file_put_contents($p, $c);
echo "replaced OK\n";
