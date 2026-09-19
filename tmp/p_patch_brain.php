<?php
$root = dirname(__DIR__);
$file = $root . '/app/Http/Controllers/TryOnController.php';
$c = file_get_contents($file);
$eol = strpos($c, "\r\n") !== false ? "\r\n" : "\n";
$fix = fn ($s) => str_replace("\n", $eol, $s);

$old = $fix(<<<'OLD'
        $key = config('services.openrouter.key');
        if ($key) {
            try {
                $response = Http::withToken($key)
                    ->timeout(12)
                    ->post('https://openrouter.ai/api/v1/chat/completions', [
                        'model'    => config('services.openrouter.brain'),
                        'messages' => [[
                            'role'    => 'user',
                            'content' => [
                                ['type' => 'text', 'text' => 'You write prompts for an image-editing / virtual try-on model. '
                                    . 'Look at the attached photo and the conditions, then rewrite the baseline prompt into ONE precise English instruction '
                                    . '(max 90 words) that fits this exact photo (head angle, cap type, lighting). Conditions: ' . json_encode($conditions)
                                    . ' Baseline prompt: ' . $base
                                    . ' Reply with the prompt text only, no quotes and no explanation.'],
                                ['type' => 'image_url', 'image_url' => ['url' => $request->input('model_image')]],
                            ],
                        ]],
                    ]);

                $text = trim((string) $response->json('choices.0.message.content'));
                if ($text !== '') {
                    return response()->json([
                        'success'    => true,
                        'prompt'     => $text,
                        'source'     => 'openrouter',
                        'conditions' => $conditions,
                    ]);
                }

                Log::warning('OpenRouter prompt builder returned no text: ' . mb_substr($response->body(), 0, 500));
            } catch (\Exception $e) {
                Log::warning('OpenRouter prompt builder failed: ' . $e->getMessage());
            }
        }
OLD);

$new = $fix(<<<'NEW'
        $key = config('services.openrouter.key');
        if ($key) {
            // Comma-separated model list: pehla fail ho (rate limit/429) to agla try hota hai.
            $models = array_values(array_filter(array_map('trim', explode(',', (string) config('services.openrouter.brain')))));

            try {
                foreach ($models as $model) {
                    $response = Http::withToken($key)
                        ->timeout(20)
                        ->post('https://openrouter.ai/api/v1/chat/completions', [
                            'model'    => $model,
                            'messages' => [[
                                'role'    => 'user',
                                'content' => [
                                    ['type' => 'text', 'text' => 'You write prompts for an image-editing / virtual try-on model. '
                                        . 'Look at the attached photo and the conditions, then rewrite the baseline prompt into ONE precise English instruction '
                                        . '(max 90 words) that fits this exact photo (head angle, cap type, lighting). Conditions: ' . json_encode($conditions)
                                        . ' Baseline prompt: ' . $base
                                        . ' Reply with the prompt text only, no quotes and no explanation.'],
                                    ['type' => 'image_url', 'image_url' => ['url' => $request->input('model_image')]],
                                ],
                            ]],
                        ]);

                    $text = trim((string) $response->json('choices.0.message.content'));
                    if ($text !== '') {
                        return response()->json([
                            'success'    => true,
                            'prompt'     => $text,
                            'source'     => 'openrouter',
                            'model'      => $model,
                            'conditions' => $conditions,
                        ]);
                    }

                    Log::warning("OpenRouter prompt builder ({$model}) returned no text: " . mb_substr($response->body(), 0, 300));
                }
            } catch (\Exception $e) {
                Log::warning('OpenRouter prompt builder failed: ' . $e->getMessage());
            }
        }
NEW);

$count = substr_count($c, $old);
if ($count !== 1) { echo "FAIL: anchor found $count time(s)" . PHP_EOL; exit(1); }
file_put_contents($file, str_replace($old, $new, $c));
echo 'OK brain fallback patch' . PHP_EOL;
