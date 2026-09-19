<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$capPath = public_path('images/caps/Kufi-removebg-preview.png');
$dataUri = 'data:image/png;base64,' . base64_encode(file_get_contents($capPath));

$r = Illuminate\Support\Facades\Http::withToken(config('services.openrouter.key'))
    ->timeout(90)
    ->post('https://openrouter.ai/api/v1/chat/completions', [
        'model'    => config('services.openrouter.brain'),
        'messages' => [[
            'role'    => 'user',
            'content' => [
                ['type' => 'text', 'text' => 'What object is in this image? Reply in max 8 words.'],
                ['type' => 'image_url', 'image_url' => ['url' => $dataUri]],
            ],
        ]],
    ]);

echo 'HTTP ' . $r->status() . PHP_EOL;
echo 'reply: ' . trim((string) $r->json('choices.0.message.content')) . PHP_EOL;
if ($r->status() !== 200) echo 'body: ' . mb_substr($r->body(), 0, 300) . PHP_EOL;
