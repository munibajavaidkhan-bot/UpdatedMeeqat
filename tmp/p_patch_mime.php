<?php
$file = dirname(__DIR__) . '/resources/views/tryon/index.blade.php';
$c = file_get_contents($file);
$eol = strpos($c, "\r\n") !== false ? "\r\n" : "\n";
$fix = fn ($s) => str_replace("\n", $eol, $s);

$report = [];
function patch2(string $c, string $needle, string $replace, string $label, array &$report) {
    global $fix, $file, $eol;
    $count = substr_count($c, $fix($needle));
    if ($count !== 1) { $report[] = "FAIL $label : anchor found $count time(s)"; return $c; }
    $report[] = "OK   $label";
    return str_replace($fix($needle), $fix($replace), $c);
}

// 1) Data-URI conversion before generation + input_images ab data-URI use karte hain
$c = patch2($c, <<<'OLD'
            this.puterPrompt = brain.prompt;
            this.puterPromptSource = brain.source;
            this.puterStatus = testMode
              ? 'Puter test mode chal raha hai (koi credit nahi lagta)...'
              : 'Puter AI fitting bana raha hai... (10-30 sec)';
OLD,
<<<'NEW'
            this.puterPrompt = brain.prompt;
            this.puterPromptSource = brain.source;
            this.puterStatus = testMode
              ? 'Puter test mode chal raha hai (koi credit nahi lagta)...'
              : 'Puter AI fitting bana raha hai... (10-30 sec)';

            // IMPORTANT: Puter ko har input image ka MIME type chahiye.
            // Relative URLs (jaise /images/caps/x.png) ka MIME detect nahi hota,
            // is liye dono images ko data-URI mein convert karte hain.
            this.puterStatus = 'Images browser ke liye tayyar ki ja rahi hain...';
            const personData = await this.puterToDataUrl(this.userImage, 'image/jpeg');
            const capData = await this.puterToDataUrl(this.selectedItem.image, 'image/png');
NEW,
'conversion before txt2img', $report);

// 2) input_images ab data-URI bhejein
$c = patch2($c, <<<'OLD'
                  input_images: [this.userImage, this.selectedItem.image],
NEW,
<<<'NEW'
                  input_images: [personData, capData],
NEW,
'input_images data-uri', $report);

// 3) puterToDataUrl helper (puterImageToDataUrl ke saath add karein)
$c = patch2($c, <<<'OLD'
        async puterImageToDataUrl(image) {
OLD,
<<<'NEW'
        /**
         * Kisi bhi image source (relative URL ya data-URI) ko data-URI bana deta hai.
         * Puter ke liye zaroori hai kyunke wahan har input ka MIME type chahiye.
         */
        async puterToDataUrl(src, mime = 'image/png') {
          if (typeof src === 'string' && src.startsWith('data:')) return src;
          const img = await this.loadImage(src);
          const cv = document.createElement('canvas');
          cv.width = img.naturalWidth;
          cv.height = img.naturalHeight;
          cv.getContext('2d').drawImage(img, 0, 0);
          return cv.toDataURL(mime, 0.92);
        },

        async puterImageToDataUrl(image) {
NEW,
'helper puterToDataUrl', $report);

file_put_contents($file, $c);
echo implode(PHP_EOL, $report) . PHP_EOL;
