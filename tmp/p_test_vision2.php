<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$capPath = public_path('images/caps/Kufi-removebg-preview.png');
$dataUri = 'data:image/png;base64,' . base64_encode(file_get_contents($capPath));

$models = ['google/gemma-4-31b-it:free', 'inclusionai/ling-3.0-flash-vl:free', 'nex-agi/nex-n2.5-pro:free'];
foreach ($models as $model) {
    $r = Illuminate\Support\Facades\Http::withToken(config('services.openrouter.key'))
        ->timeout(90)
        ->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'    => $model,
            'messages' => [[
                'role'    => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'What object is in this image? Reply in max 8 words.'],
                    ['type' => 'image_url', 'image_url' => ['url' => $dataUri]],
                ],
            ]],
        ]);
    $reply = trim((string) $r->json('choices.0.message.content'));
    echo "$model -> HTTP {$r->status()} | reply: " . ($reply ?: mb_substr($r->body(), 0, 120)) . PHP_EOL;
}
