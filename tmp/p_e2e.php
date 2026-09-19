<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simulate the frontend call to /tryon/prompt directly through the HTTP kernel
$dataUri = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/caps/Kufi-removebg-preview.png')));

$req = Illuminate\Http\Request::create('/tryon/prompt', 'POST', [
    'model_image' => $dataUri,
    'item_id'     => 1,
    'upload_mode' => 'file',
    'extra_note'  => 'Kufi Cap',
]);
$req->headers->set('Content-Type', 'application/json');

$res = $app->handle($req);
echo 'HTTP ' . $res->getStatusCode() . PHP_EOL;
$j = json_decode($res->getContent(), true);
echo 'success: ' . var_export($j['success'] ?? null, true) . PHP_EOL;
echo 'source: ' . ($j['source'] ?? 'N/A') . PHP_EOL;
echo 'model: ' . ($j['model'] ?? '-') . PHP_EOL;
echo 'prompt (first 300 chars):' . PHP_EOL . mb_substr($j['prompt'] ?? '(none)', 0, 300) . PHP_EOL;
