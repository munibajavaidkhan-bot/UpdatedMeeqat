<?php
$file = dirname(__DIR__) . '/resources/views/tryon/index.blade.php';
$c = file_get_contents($file);

$needle = 'async puterImageToDataUrl(image) {';
$count = substr_count($c, $needle);
if ($count !== 1) { echo "FAIL: anchor found $count time(s)" . PHP_EOL; exit(1); }

$helper = <<<'HELPER'
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

HELPER;

file_put_contents($file, str_replace($needle, $helper . $needle, $c));
echo 'OK helper added' . PHP_EOL;
