<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo 'brain model: ' . config('services.openrouter.brain') . PHP_EOL;

$r = Illuminate\Support\Facades\Http::withToken(config('services.openrouter.key'))
    ->timeout(60)
    ->post('https://openrouter.ai/api/v1/chat/completions', [
        'model'    => config('services.openrouter.brain'),
        'messages' => [['role' => 'user', 'content' => 'Reply with the single word: READY']],
    ]);

echo 'HTTP ' . $r->status() . PHP_EOL;
echo 'reply: ' . trim((string) $r->json('choices.0.message.content')) . PHP_EOL;
if ($r->status() !== 200) echo 'body: ' . mb_substr($r->body(), 0, 300) . PHP_EOL;
