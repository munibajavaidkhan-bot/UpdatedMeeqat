<?php
$root = dirname(__DIR__);
$report = [];

function patch(string $file, string $needle, string $replace, array &$report, string $label): bool {
    if (!is_file($file)) { $report[] = "FAIL $label : file missing ($file)"; return false; }
    $c = file_get_contents($file);
    $eol = strpos($c, "\r\n") !== false ? "\r\n" : "\n";
    $n = str_replace("\n", $eol, $needle);
    $r = str_replace("\n", $eol, $replace);
    $count = substr_count($c, $n);
    if ($count !== 1) { $report[] = "FAIL $label : anchor found $count time(s)"; return false; }
    file_put_contents($file, str_replace($n, $r, $c));
    $report[] = "OK   $label";
    return true;
}

// 1) config/services.php -> openrouter block
patch(
    $root . '/config/services.php',
    "    'huggingface' => [\n        'token' => env('HF_TOKEN'),\n    ],\n",
    "    'huggingface' => [\n        'token' => env('HF_TOKEN'),\n    ],\n\n    // OpenRouter is OPTIONAL: used only to write a smarter try-on prompt\n    // for the browser-side Puter.js generation. Without a key the\n    // deterministic prompt template in TryOnController::prompt() is used.\n    'openrouter' => [\n        'key'   => env('OPENROUTER_API_KEY'),\n        'brain' => env('OPENROUTER_BRAIN_MODEL', 'google/gemini-2.5-flash'),\n        'image' => env('OPENROUTER_IMAGE_MODEL', 'google/gemini-2.5-flash-image'),\n    ],\n",
    $report, 'services.php / openrouter config'
);

// 2) routes/web.php -> tryon.prompt
patch(
    $root . '/routes/web.php',
    "    Route::post('/save', [TryOnController::class, 'save'])->name('save'); // Agar guest users ko bhi save allow karna hai toh middleware('auth') hata diya hai\n",
    "    Route::post('/save', [TryOnController::class, 'save'])->name('save'); // Agar guest users ko bhi save allow karna hai toh middleware('auth') hata diya hai\n    Route::post('/prompt', [TryOnController::class, 'prompt'])->name('prompt'); // Puter.js demo ke liye AI prompt builder\n",
    $report, 'routes/web.php / tryon.prompt route'
);

// 3) TryOnController -> prompt() method
$method = <<<'PHPEOF'
    /**
     * Build the image-edit prompt used by the browser-side Puter.js generation.
     *
     * Works with no API key at all (deterministic template). When an
     * OPENROUTER_API_KEY is configured, a vision model looks at the uploaded
     * photo and rewrites the template into a sharper, photo-specific prompt.
     */
    public function prompt(Request $request)
    {
        $request->validate([
            'model_image' => 'required|string',
            'item_id'     => 'required|integer',
            'upload_mode' => 'nullable|string|in:file,camera,library',
            'extra_note'  => 'nullable|string|max:200',
        ]);

        $itemId = (int) $request->input('item_id');
        if (!isset($this->productsCatalog[$itemId])) {
            return response()->json(['success' => false, 'message' => 'Selected product is invalid or unavailable.'], 400);
        }

        $capNames = [
            1 => 'white knitted Kufi prayer cap',
            2 => 'taqiyah prayer cap',
            3 => 'Amama turban',
        ];
        $capName = $capNames[$itemId];

        $base = 'Virtual try-on: place the ' . $capName . ' (shown in the second image) naturally on the head of the person in the first image. '
            . 'Photorealistic result with correct perspective, size and angle matching the head pose, and lighting, shadows and colour grading that match the original photo. '
            . 'Keep the person\'s face, the hair visible below the cap, clothing, pose and background exactly unchanged. '
            . 'The cap rim must sit naturally on the forehead like a real prayer cap worn in daily life. '
            . 'Do not change the framing and do not add any text or watermark. Output only the edited image.';

        $conditions = [
            'cap'         => $capName,
            'upload_mode' => $request->input('upload_mode', 'file'),
            'note'        => $request->input('extra_note'),
        ];

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

        return response()->json([
            'success'    => true,
            'prompt'     => $base,
            'source'     => 'template',
            'conditions' => $conditions,
        ]);
    }

PHPEOF;

patch(
    $root . '/app/Http/Controllers/TryOnController.php',
    "    /**\n     * Save try-on result\n     */\n",
    $method . "    /**\n     * Save try-on result\n     */\n",
    $report, 'TryOnController / prompt() method'
);

echo implode(PHP_EOL, $report) . PHP_EOL;
