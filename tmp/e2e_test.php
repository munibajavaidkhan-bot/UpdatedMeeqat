<?php
// Simulate the frontend request: call /tryon/generate directly via PHP
$faceFile = getenv('TEMP') . DIRECTORY_SEPARATOR . 'test_face.jpg';
$compFile = getenv('TEMP') . DIRECTORY_SEPARATOR . 'composite.jpg';
if (!file_exists($compFile)) { die("composite missing\n"); }
$base = 'http://127.0.0.1:8099';

// Get CSRF token + session
$ck = getenv('TEMP') . DIRECTORY_SEPARATOR . 'cookies.txt';
$ch = curl_init($base . '/tryon');
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIEJAR => $ck, CURLOPT_COOKIEFILE => $ck]);
$html = curl_exec($ch);
curl_close($ch);
preg_match('/name="csrf-token" content="([^"]+)"/', $html, $m);
$token = $m[1] ?? '';
echo 'token: ' . substr($token, 0, 10) . "...\n";

$post = json_encode([
  'model_image' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($faceFile)),
  'item_id' => 1,
  'qwen_composite' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($compFile)),
]);
$ch = curl_init($base . '/tryon/generate');
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_POSTFIELDS => $post,
  CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'X-CSRF-TOKEN: ' . $token, 'Accept: application/json'],
  CURLOPT_COOKIEFILE => $ck,
  CURLOPT_TIMEOUT => 280,
]);
$resp = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
echo "HTTP $code\n";
$j = json_decode($resp, true);
if ($j) {
  echo 'success: ' . var_export($j['success'] ?? null, true) . "\n";
  echo 'provider: ' . ($j['provider'] ?? '-') . "\n";
  echo 'message: ' . ($j['message'] ?? '-') . "\n";
  if (!empty($j['result_image'])) {
    $b64 = preg_replace('#^data:image/[^;]+;base64,#', '', $j['result_image']);
    file_put_contents(getenv('TEMP') . DIRECTORY_SEPARATOR . 'final_e2e.png', base64_decode($b64));
    echo 'result saved: ' . strlen($b64) . " b64 chars\n";
  }
} else {
  echo substr((string)$resp, 0, 300) . "\n";
}
