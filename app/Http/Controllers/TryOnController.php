<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TryOnController extends Controller
{
    /**
     * Fixed product catalog mapping ID to internal image paths
     */
    private array $productsCatalog = [
        1 => '/images/caps/Kufi-removebg-preview.png',
        2 => '/images/caps/taqiyah-removebg-preview.png',
        3 => '/images/caps/Amama-removebg-preview.png',
    ];

    /**
     * Display the Virtual Try-On page.
     */
    public function index()
    {
        if (!auth()->check()) {
            // Remember this page so Login sends the member back to Virtual Try-On.
            redirect()->setIntendedUrl(route('tryon.index'));
        }

        return view('tryon.index');
    }

    /**
     * Members-only generation history (files saved under storage/app/public/tryon).
     */
    public function history()
    {
        $userId = auth()->id();
        $items  = [];

        foreach (Storage::disk('public')->files('tryon') as $path) {
            $filename = basename($path);

            // Files are named tryon_{userId}_{timestamp}.jpg by save()
            if (!preg_match('/^tryon_' . $userId . '_(\d+)\.(jpg|jpeg|png|webp)$/i', $filename, $m)) {
                continue;
            }

            $items[] = [
                'filename' => $filename,
                'url'      => Storage::url($path),
                'date'     => date('d M Y, h:i A', (int) $m[1]),
                'timestamp' => (int) $m[1],
            ];
        }

        usort($items, fn ($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return response()->json(['success' => true, 'items' => array_slice($items, 0, 12)]);
    }

    /**
     * Delete a saved try-on result (owner only).
     */
    public function deleteHistory(Request $request, string $filename)
    {
        if (!preg_match('/^tryon_' . auth()->id() . '_\d+\.(jpg|jpeg|png|webp)$/i', $filename)) {
            return response()->json(['success' => false, 'message' => 'Invalid file.'], 400);
        }

        $path = 'tryon/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Process AI Generation using fixed models/caps catalog
     */
    public function generate(Request $request)
    {
        $request->validate([
            'model_image' => 'required|string', // Base64 or Image URL of User
            'item_id'        => 'required|integer',
            'qwen_composite' => 'nullable|string',
        ]);

        $itemId = (int) $request->input('item_id');
        if (!isset($this->productsCatalog[$itemId])) {
            return response()->json(['success' => false, 'fallback' => true, 'message' => 'Selected product is invalid or unavailable.'], 400);
        }

        $apiKey = config('services.gemini.key');
        if (!$apiKey) {
            // Frontend will fall back to the browser (canvas) try-on engine.
            return response()->json(['success' => false, 'fallback' => true, 'message' => 'GEMINI_API_KEY not configured.']);
        }

        try {
            $raw = $request->input('model_image');
            $userMime = 'image/jpeg';
            $userB64 = null;

            if (preg_match('#^data:image/(\w+);base64,#i', $raw, $m)) {
                $userMime = 'image/' . strtolower($m[1]);
                $userB64 = preg_replace('#^data:image/\w+;base64,#i', '', $raw);
            } elseif (filter_var($raw, FILTER_VALIDATE_URL)) {
                $bytes = Http::timeout(30)->get($raw)->body();
                $userB64 = base64_encode($bytes);
            } else {
                $userB64 = $raw;
            }

            $capPath = public_path($this->productsCatalog[$itemId]);
            if (!file_exists($capPath)) {
                return response()->json(['success' => false, 'fallback' => true, 'message' => 'Product image file missing.'], 500);
            }
            $capB64 = base64_encode(file_get_contents($capPath));

            $prompt = 'Virtual try-on task: The first image shows a person. The second image is a cap product photo. '
                . 'Edit the first image so the person is wearing this cap on their head. Requirements: '
                . 'place the cap naturally on the head with correct perspective, size and angle matching the head pose; '
                . 'photorealistic result with matching lighting, shadows and color grading; '
                . 'keep the person face, hair visible below the cap, clothing, pose and background exactly unchanged; '
                . 'the cap edge should sit naturally like a real prayer cap (kufi) worn in real life; '
                . 'do not change image framing or add any text or watermark. Output only the edited image.';

            $payload = [
                'contents' => [[
                    'parts' => [
                        ['text' => $prompt],
                        ['inlineData' => ['mimeType' => $userMime, 'data' => $userB64]],
                        ['inlineData' => ['mimeType' => 'image/png', 'data' => $capB64]],
                    ],
                ]],
                'generationConfig' => ['responseModalities' => ['TEXT', 'IMAGE']],
            ];

            $response = Http::timeout(180)->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-image:generateContent?key=' . $apiKey,
                $payload
            );

            if ($response->failed()) {
                Log::error('Gemini API Error: ' . $response->body());
                                $hfResult = $this->tryHuggingFace($userB64, $capB64);
                if ($hfResult) {
                    return response()->json(['success' => true, 'result_image' => $hfResult, 'provider' => 'huggingface']);
                }

                $qwenResult = $this->tryQwen($request->input('qwen_composite'));
                if ($qwenResult) {
                    return response()->json(['success' => true, 'result_image' => $qwenResult, 'provider' => 'qwen']);
                }
return response()->json(['success' => false, 'fallback' => true, 'message' => 'AI generation failed.'], 500);
            }

            $data = $response->json();
            foreach ($data['candidates'][0]['content']['parts'] ?? [] as $part) {
                $inline = $part['inlineData'] ?? $part['inline_data'] ?? null;
                if (!empty($inline['data'])) {
                    $mime = $inline['mimeType'] ?? $inline['mime_type'] ?? 'image/png';
                    return response()->json([
                        'success'      => true,
                        'result_image' => 'data:' . $mime . ';base64,' . $inline['data'],
                    ]);
                }
            }

            Log::error('Gemini response missing image: ' . mb_substr(json_encode($data), 0, 1000));
                        $hfResult = $this->tryHuggingFace($userB64, $capB64);
            if ($hfResult) {
                return response()->json(['success' => true, 'result_image' => $hfResult, 'provider' => 'huggingface']);
            }

                $qwenResult = $this->tryQwen($request->input('qwen_composite'));
                if ($qwenResult) {
                    return response()->json(['success' => true, 'result_image' => $qwenResult, 'provider' => 'qwen']);
                }
return response()->json(['success' => false, 'fallback' => true, 'message' => 'AI did not return an image.'], 500);

        } catch (\Exception $e) {
            Log::error('TryOn Generate Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'fallback' => true, 'message' => 'AI generation failed.'], 500);
        }
    }
    /**
     * AI-based cap adjustment for manual nudge commands
     */
    public function aiAdjust(Request $request)
    {
        $request->validate([
            'prompt'   => 'required|string|max:255',
            'cap_type' => 'required|string',
            'current'  => 'nullable|array',
        ]);

        $prompt = strtolower(trim($request->prompt));
        $adjustments = $request->current ?? [];

        if (preg_match('/fix|center|settle|place|position|auto/i', $prompt)) {
            $adjustments = ['x' => 50, 'y' => 18, 'scale' => 1.0, 'width' => 200, 'rotation' => 0];
            $message = 'Cap reset to center position.';
        } else {
            if (preg_match('/\bup\b/i', $prompt))    $adjustments['y'] = max(0, ($adjustments['y'] ?? 50) - 5);
            if (preg_match('/\bdown\b/i', $prompt))  $adjustments['y'] = min(80, ($adjustments['y'] ?? 50) + 5);
            if (preg_match('/\bleft\b/i', $prompt))  $adjustments['x'] = max(5, ($adjustments['x'] ?? 50) - 5);
            if (preg_match('/\bright\b/i', $prompt)) $adjustments['x'] = min(95, ($adjustments['x'] ?? 50) + 5);

            if (preg_match('/bigger|larger|increase|zoom.?in/i', $prompt)) {
                $adjustments['scale'] = min(1.5, ($adjustments['scale'] ?? 1) + 0.15);
            }
            if (preg_match('/smaller|shrink|decrease|zoom.?out/i', $prompt)) {
                $adjustments['scale'] = max(0.5, ($adjustments['scale'] ?? 1) - 0.15);
            }

            $message = 'Applied adjustment: ' . $request->prompt;
        }

        return response()->json([
            'success'     => true,
            'message'     => $message,
            'adjustments' => $adjustments,
        ]);
    }

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

        return response()->json([
            'success'    => true,
            'prompt'     => $base,
            'source'     => 'template',
            'conditions' => $conditions,
        ]);
    }
    /**
     * Save try-on result
     */
    public function save(Request $request)
    {
        $request->validate([
            'result_image' => 'required|string',
        ]);

        try {
            $decoded = base64_decode(
                preg_replace('#^data:image/\w+;base64,#i', '', $request->result_image),
                true
            );

            if ($decoded === false) {
                return response()->json(['success' => false, 'message' => 'Invalid image data.'], 400);
            }

            $filename = 'tryon_' . (auth()->id() ?? 'guest') . '_' . time() . '.jpg';
            Storage::disk('public')->put('tryon/' . $filename, $decoded);

            return response()->json([
                'success'  => true,
                'message'  => 'Try-On result saved successfully!',
                'filename' => $filename,
                'url'      => Storage::url('tryon/' . $filename),
            ]);
        } catch (\Exception $e) {
            Log::error('TryOn save failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save try-on result.'], 500);
        }
    }

    /**
     * Helper to save base64 image temporary to public storage
     */

    /**
     * Free fallback: Hugging Face IDM-VTON space (best-effort, may be unavailable).
     * Returns a data URL on success or null on any failure.
     */
    private function tryHuggingFace(string $userB64, string $capB64): ?string
    {
        try {
            set_time_limit(300);
            $base = 'https://yisol-idm-vton.hf.space';

            $uploadMultipart = function (string $dataB64, string $filename, string $mime) use ($base) {
    $res = Http::timeout(60)
        ->attach('files', base64_decode($dataB64), $filename, ['Content-Type' => $mime])
        ->post($base . '/upload');
    $json = $res->json();
    return (is_array($json) && isset($json[0])) ? $json[0] : null;
};

            $humanPath = $uploadMultipart($userB64, 'human.jpg', 'image/jpeg');
            $garmentPath = $uploadMultipart($capB64, 'garment.png', 'image/png');
            if (!$humanPath || !$garmentPath) {
                Log::warning('HF upload failed');
                return null;
            }

            $join = Http::timeout(60)->post($base . '/call/tryon', [
                'data' => [
                    ['path' => $humanPath, 'meta' => ['_type' => 'gradio.FileData']],
                    ['path' => $humanPath, 'meta' => ['_type' => 'gradio.FileData']],
                    ['path' => $garmentPath, 'meta' => ['_type' => 'gradio.FileData']],
                    true, false, 30, 42,
                ],
            ]);
            $eventId = $join->json('event_id');
            if (!$eventId) {
                Log::warning('HF join failed: ' . $join->body());
                return null;
            }

            $result = Http::timeout(280)->get($base . '/call/tryon/' . $eventId);
            $respBody = $result->body();

            if (preg_match('/event:\s*error/', $respBody)) {
                Log::warning('HF space returned error event');
                return null;
            }

            if (preg_match('/data:\s*(\{.*\})/', $respBody, $m)) {
                $payload = json_decode($m[1], true);
                $url = $payload['url'] ?? ($payload['path'] ?? null);
                if ($url && str_starts_with($url, 'http')) {
                    $img = Http::timeout(60)->get($url);
                    if ($img->successful()) {
                        return 'data:image/png;base64,' . base64_encode($img->body());
                    }
                }
            }

            Log::warning('HF unexpected response: ' . mb_substr($respBody, 0, 300));
            return null;
        } catch (\Exception $e) {
            Log::warning('HF fallback failed: ' . $e->getMessage());
            return null;
        }
    }


    /**
     * Free fallback: Qwen-Image-Edit ZeroGPU space (best-effort).
     * Expects a composite image (person + cap side by side).
     * Returns a data URL on success or null on any failure.
     */
    private function tryQwen(?string $compositeB64): ?string
    {
        try {
            set_time_limit(300);
            if (!$compositeB64) {
                return null;
            }
            $base = 'https://qwen-qwen-image-edit.hf.space';
            $token = config('services.huggingface.token', env('HF_TOKEN'));

            $headers = [];
if ($token) {
    $headers['Authorization'] = 'Bearer ' . $token;
}
$res = Http::timeout(60)
    ->withHeaders($headers)
    ->attach('files', base64_decode($compositeB64), 'composite.jpg', ['Content-Type' => 'image/jpeg'])
    ->post($base . '/gradio_api/upload');
            $json = $res->json();
            $path = (is_array($json) && isset($json[0])) ? $json[0] : null;
            if (!$path) {
                Log::warning('Qwen upload failed');
                return null;
            }

            $apiHeaders = [];
            if ($token) {
                $apiHeaders['Authorization'] = 'Bearer ' . $token;
            }
            $join = Http::timeout(60)->withHeaders($apiHeaders)->post($base . '/gradio_api/call/infer', [
                'data' => [
                    ['path' => $path, 'meta' => ['_type' => 'gradio.FileData']],
                    'Place the white knitted prayer cap from the right side of the image onto the head of the man on the left side. Photorealistic, keep his face, clothing and background unchanged. Output only the edited image of the man wearing the cap.',
                    42, true, 4.0, 50, false,
                ],
            ]);
            $eventId = $join->json('event_id');
            if (!$eventId) {
                Log::warning('Qwen join failed: ' . $join->body());
                return null;
            }

            $result = Http::timeout(280)->withHeaders($apiHeaders)->get($base . '/gradio_api/call/infer/' . $eventId);
            $respBody = $result->body();

            if (preg_match('/event:\s*error/', $respBody)) {
                Log::warning('Qwen space returned error event');
                return null;
            }

            if (preg_match('/data:\s*(\[.*\])/', $respBody, $m)) {
                $payload = json_decode($m[1], true);
                $url = $payload[0]['url'] ?? ($payload[0]['path'] ?? null);
                if ($url && str_starts_with($url, 'http')) {
                    $img = Http::timeout(60)->get($url);
                    if ($img->successful()) {
                        return 'data:image/png;base64,' . base64_encode($img->body());
                    }
                }
            }

            Log::warning('Qwen unexpected response: ' . mb_substr($respBody, 0, 300));
            return null;
        } catch (\Exception $e) {
            Log::warning('Qwen fallback failed: ' . $e->getMessage());
            return null;
        }
    }

    private function saveTempImage($imageData, $prefix)
    {
        if (filter_var($imageData, FILTER_VALIDATE_URL)) {
            return $imageData;
        }

        $imageParts = explode(";base64,", $imageData);
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageType = $imageTypeAux[1] ?? 'png';
        $imageBase64 = base64_decode($imageParts[1] ?? $imageData);

        $fileName = $prefix . '_' . uniqid() . '.' . $imageType;
        Storage::disk('public')->put('tryon_temp/' . $fileName, $imageBase64);

        return asset('storage/tryon_temp/' . $fileName);
    }

    /**
     * Poll Replicate API status
     */
    private function pollPredictionResult($predictionId, $apiToken)
    {
        $status = 'starting';
        $resultUrl = null;
        $maxRetries = 15;
        $retryCount = 0;

        while (in_array($status, ['starting', 'processing']) && $retryCount < $maxRetries) {
            sleep(1);
            $checkResponse = Http::withHeaders([
                'Authorization' => 'Token ' . $apiToken,
            ])->get("https://api.replicate.com/v1/predictions/{$predictionId}");

            $data = $checkResponse->json();
            $status = $data['status'] ?? 'failed';

            if ($status === 'succeeded') {
                $resultUrl = is_array($data['output']) ? $data['output'][0] : $data['output'];
                break;
            }
            $retryCount++;
        }

        return $resultUrl;
    }
}
