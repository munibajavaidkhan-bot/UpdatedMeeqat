<?php
$file = dirname(__DIR__) . '/resources/views/tryon/index.blade.php';
$c = file_get_contents($file);
$eol = strpos($c, "\r\n") !== false ? "\r\n" : "\n";
$fix = fn ($s) => str_replace("\n", $eol, $s);

$old = $fix(<<<'OLD'
            const image = await puter.ai.txt2img({
              prompt: brain.prompt,
              provider: 'gemini',
              input_images: [this.userImage, this.selectedItem.image],
              test_mode: testMode
            });
OLD);

$new = $fix(<<<'NEW'
            // IMPORTANT: Gemini needs an explicit model name (docs example:
            // model: "gemini-3.1-flash-image-preview"). provider: 'gemini' alone
            // gives a "Missing model" error. Pehla model fail ho to agla try.
            const puterModels = ['gemini-3.1-flash-image-preview', 'gemini-2.5-flash-image'];
            let image = null;
            let lastGenErr = null;
            for (const model of puterModels) {
              try {
                image = await puter.ai.txt2img({
                  prompt: brain.prompt,
                  model: model,
                  input_images: [this.userImage, this.selectedItem.image],
                  test_mode: testMode
                });
                break;
              } catch (genErr) {
                lastGenErr = genErr;
                console.warn('Puter model fail hua (' + model + '):', genErr);
              }
            }
            if (!image) throw lastGenErr;
NEW);

$count = substr_count($c, $old);
if ($count !== 1) { echo "FAIL: anchor found $count time(s)" . PHP_EOL; exit(1); }
file_put_contents($file, str_replace($old, $new, $c));
echo 'OK model fix patch' . PHP_EOL;
