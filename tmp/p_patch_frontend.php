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

$blade = $root . '/resources/views/tryon/index.blade.php';

// 1) Puter.js SDK
patch($blade,
"  <script>\n    document.addEventListener('alpine:init', () => {\n",
"  <!-- Puter.js: browser-side AI image generation (koi API key server par nahi chahiye) -->\n  <script src=\"https://js.puter.com/v2/\"></script>\n\n  <script>\n    document.addEventListener('alpine:init', () => {\n",
$report, 'blade / puter script tag');

// 2) Alpine state
patch($blade,
"        qwenSplitRatio: null,\n        uploadMode: 'file',\n",
"        qwenSplitRatio: null,\n        uploadMode: 'file',\n        isPuterBusy: false,\n        puterStatus: null,\n        puterPrompt: null,\n        puterPromptSource: null,\n        puterImage: null,\n",
$report, 'blade / puter state');

// 3) Demo card (LEFT panel)
$card = <<<'HTMLEOF'
            <span x-text="isGeneratingAI ? 'Fitting cap...' : 'Generate (Cap Auto-Fit)'"></span>
          </button>

          <!-- STEP 4: Puter.js demo (frontend AI generation) -->
          <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
              <span class="flex items-center justify-center w-7 h-7 rounded-full bg-emerald-600 text-white font-bold text-sm">4</span>
              <h2 class="text-lg font-bold text-gray-800">Puter.js AI Demo</h2>
              <span class="ml-auto text-xs font-semibold text-white bg-emerald-600 rounded-full px-2 py-0.5">Beta</span>
            </div>

            <p class="text-xs text-gray-500 mb-3">
              Prompt backend banata hai (OpenRouter key ho to AI likhega, warna template) aur image browser mein Puter.js generate karta hai.
            </p>

            <div class="grid grid-cols-2 gap-3">
              <button @click="runPuterDemo(true)" :disabled="isPuterBusy"
                class="border border-gray-300 hover:border-emerald-500 disabled:opacity-40 font-bold py-2.5 rounded-xl text-gray-700 text-xs">
                Test (credits nahi)
              </button>
              <button @click="runPuterDemo(false)" :disabled="isPuterBusy"
                class="bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white font-bold py-2.5 rounded-xl text-xs">
                Real Generate
              </button>
            </div>

            <button @click="runPuterExample()" :disabled="isPuterBusy"
              class="mt-3 w-full border border-gray-300 hover:border-emerald-500 disabled:opacity-40 font-bold py-2.5 rounded-xl text-gray-700 text-xs">
              Puter basic example (text to image, test mode)
            </button>

            <div x-show="puterStatus" x-cloak class="mt-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl px-3 py-2">
              <span x-text="puterStatus"></span>
            </div>

            <div x-show="puterPrompt" x-cloak class="mt-3 bg-slate-50 border border-gray-200 rounded-xl p-3" style="max-height:7rem;overflow:auto">
              <p class="text-xs font-semibold text-gray-600 mb-1">
                Prompt <span class="text-gray-400" x-text="puterPromptSource ? '(' + puterPromptSource + ')' : ''"></span>
              </p>
              <p class="text-xs text-gray-500" x-text="puterPrompt"></p>
            </div>

            <template x-if="puterImage">
              <div class="mt-4">
                <img :src="puterImage" alt="Puter AI result" class="w-full rounded-xl border border-gray-200">
                <button @click="finalImage = puterImage; viewMode = 'result'"
                  class="mt-3 w-full border border-emerald-500 text-emerald-600 hover:bg-emerald-50 font-bold py-2.5 rounded-xl text-xs">
                  Ye result canvas mein use karein
                </button>
              </div>
            </template>
          </div>
        </div>
HTMLEOF;
patch($blade,
"            <span x-text=\"isGeneratingAI ? 'Fitting cap...' : 'Generate (Cap Auto-Fit)'\"></span>\n          </button>\n        </div>\n",
$card,
$report, 'blade / puter demo card');

// 4) Alpine methods
$js = <<<'JSEOF'
        puterErrorMessage(err) {
          const code = err?.code || err?.error?.code || '';
          if (code === 'insufficient_funds') return 'Puter ka monthly credit khatam ho gaya. Puter account upgrade karein ya naya mahina aane dein.';
          if (code === 'too_many_requests') return 'Puter rate limit lag gaya. Thori dair baad dobara try karein.';
          if (code === 'storage_limit_reached') return 'Puter filesystem full hai. Purani files delete karein.';
          return 'Puter generate nahi kar saka: ' + (err?.message || err);
        },

        async puterImageToDataUrl(image) {
          if (typeof image === 'string') return image;
          const w = image.naturalWidth || image.width;
          const h = image.naturalHeight || image.height;
          const canvas = document.createElement('canvas');
          canvas.width = w;
          canvas.height = h;
          canvas.getContext('2d').drawImage(image, 0, 0);
          return canvas.toDataURL('image/jpeg', 0.92);
        },

        /**
         * Puter.js demo:
         * 1) backend se prompt mangwao (template ya OpenRouter)
         * 2) wohi prompt Puter ko de do, sath mein person + cap images
         * 3) result ko dataURL bana kar dikhao
         */
        async runPuterDemo(testMode = false) {
          if (!this.userImage) return alert('Pehle photo upload ya capture karein.');
          if (!this.selectedItem) return alert('Pehle cap select karein.');
          if (!window.puter?.ai?.txt2img) {
            this.puterStatus = 'Puter.js load nahi hua (internet ya CDN block check karein).';
            return;
          }

          this.isPuterBusy = true;
          this.puterImage = null;
          this.puterStatus = 'Backend se prompt ban raha hai...';

          try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const brain = await fetch('/tryon/prompt', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
              body: JSON.stringify({
                model_image: this.userImage,
                item_id: this.selectedItem.id,
                upload_mode: this.uploadMode,
                extra_note: this.selectedItem.name
              })
            }).then(r => r.json());

            if (!brain || !brain.prompt) throw new Error(brain?.message || 'Prompt build nahi hua.');

            this.puterPrompt = brain.prompt;
            this.puterPromptSource = brain.source;
            this.puterStatus = testMode
              ? 'Puter test mode chal raha hai (koi credit nahi lagta)...'
              : 'Puter AI fitting bana raha hai... (10-30 sec)';

            const image = await puter.ai.txt2img({
              prompt: brain.prompt,
              provider: 'gemini',
              input_images: [this.userImage, this.selectedItem.image],
              test_mode: testMode
            });

            this.puterImage = await this.puterImageToDataUrl(image);
            this.puterStatus = testMode
              ? 'Wiring theek hai. Ab Real Generate try karein.'
              : 'Puter AI result tayyar hai.';
          } catch (err) {
            console.error('Puter demo error:', err);
            this.puterStatus = this.puterErrorMessage(err);
          } finally {
            this.isPuterBusy = false;
          }
        },

        async runPuterExample() {
          if (!window.puter?.ai?.txt2img) {
            this.puterStatus = 'Puter.js load nahi hua (internet ya CDN block check karein).';
            return;
          }

          this.isPuterBusy = true;
          this.puterImage = null;
          this.puterPrompt = 'A realistic luxury hotel photography, professional lighting';
          this.puterPromptSource = 'doc-example';
          this.puterStatus = 'Puter basic example chal raha hai...';

          try {
            const image = await puter.ai.txt2img(
              'A realistic luxury hotel photography, professional lighting',
              true // test mode: sample image, koi credit nahi
            );
            this.puterImage = await this.puterImageToDataUrl(image);
            this.puterStatus = 'Puter.js theek chal raha hai.';
          } catch (err) {
            console.error('Puter example error:', err);
            this.puterStatus = this.puterErrorMessage(err);
          } finally {
            this.isPuterBusy = false;
          }
        },

        async saveAndDownload() {
JSEOF;
patch($blade, "        async saveAndDownload() {\n", $js, $report, 'blade / puter methods');

// 5) footer -> Powered by Puter link (Puter ki requirement)
patch($root . '/resources/views/layouts/partials/footer.blade.php',
"            <p style=\"color:rgba(71,85,105,.6);font-size:.75rem\">\n                Made with care for Hajj &amp; Umrah pilgrims\n            </p>\n",
"            <p style=\"color:rgba(71,85,105,.6);font-size:.75rem\">\n                Made with care for Hajj &amp; Umrah pilgrims\n            </p>\n            <p style=\"color:rgba(71,85,105,.6);font-size:.75rem\">\n                AI try-on demo:\n                <a href=\"https://developer.puter.com\" target=\"_blank\" rel=\"noopener noreferrer\" style=\"color:#34d399\">Powered by Puter</a>\n            </p>\n",
$report, 'footer / powered by puter');

echo implode(PHP_EOL, $report) . PHP_EOL;
