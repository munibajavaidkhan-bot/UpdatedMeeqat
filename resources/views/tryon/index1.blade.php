@extends('layouts.app')

@section('content')
  <div class="bg-gray-50 min-h-screen pb-12" x-data="tryOnApp()">

    <!-- Hero Banner -->
    <div class="bg-slate-900 text-white relative overflow-hidden py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between relative z-10">
        <div class="mb-6 md:mb-0 max-w-xl">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-4">
            <svg class="w-3.5 h-3.5 mr-1.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
              <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
            </svg>
            AR & AI Powered Try-On
          </span>
          <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">
            Virtual <span class="text-emerald-400">Try-On</span>
          </h1>
          <p class="mt-3 text-base text-gray-300 sm:text-lg">
            Upload your photo and select any cap or accessory to visualize instantly.
          </p>
        </div>
        <div class="w-full md:w-1/3 h-48 rounded-2xl overflow-hidden shadow-2xl relative border border-slate-700">
          <img src="/images/kaaba-bg.jpg" class="w-full h-full object-cover" alt="Background"
            onerror="this.src='https://images.unsplash.com/photo-1591604466107-ec97de577aff?w=600'">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
        </div>
      </div>
    </div>

    <!-- Main Workspace -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT PANEL -->
        <div class="lg:col-span-5 space-y-6">

          <!-- STEP 1 -->
          <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
              <span class="flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white font-bold text-sm">1</span>
              <h2 class="text-lg font-bold text-gray-800">Upload Your Photo</h2>
            </div>

            <div class="flex bg-slate-100 p-1 rounded-xl text-xs font-semibold mb-4">
              <button @click="switchToFile()" :class="uploadMode === 'file' ? 'bg-white text-emerald-600 shadow' : 'text-gray-500'" class="flex-1 px-2 py-2 rounded-lg transition">Upload</button>
              <button @click="switchToCamera()" :class="uploadMode === 'camera' ? 'bg-white text-emerald-600 shadow' : 'text-gray-500'" class="flex-1 px-2 py-2 rounded-lg transition">Camera</button>
              <button @click="switchToModelLibrary()" :class="uploadMode === 'library' ? 'bg-white text-emerald-600 shadow' : 'text-gray-500'" class="flex-1 px-2 py-2 rounded-lg transition">Models</button>
            </div>

            <div x-show="uploadMode === 'file'">
              <template x-if="!userImage">
                <label class="border-2 border-dashed border-emerald-200 hover:border-emerald-500 rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer transition bg-emerald-50/30">
                  <input type="file" @change="handleFileUpload" accept="image/*" class="hidden">
                  <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                  </div>
                  <span class="text-sm font-semibold text-gray-800">Upload Front-facing Photo</span>
                  <span class="text-xs text-gray-400 mt-1">JPG, PNG or WEBP (Max 5MB)</span>
                </label>
              </template>
              <template x-if="userImage">
                <div class="flex items-center space-x-4 border border-gray-200 rounded-xl p-3">
                  <img :src="userImage" class="w-16 h-16 object-cover rounded-lg border">
                  <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">Photo ready ✅</p>
                    <p class="text-xs" :class="faceData ? 'text-emerald-600' : (modelsLoaded ? 'text-amber-600' : 'text-gray-400')"
                       x-text="faceData ? '✓ Face detected' : (modelsLoaded ? 'Detecting face...' : 'Loading AI models...')"></p>
                  </div>
                  <label class="text-xs font-bold text-emerald-600 cursor-pointer">Change
                    <input type="file" @change="handleFileUpload" accept="image/*" class="hidden">
                  </label>
                </div>
              </template>
            </div>

            <div x-show="uploadMode === 'camera'" x-cloak>
              <div class="relative bg-slate-900 rounded-xl overflow-hidden aspect-[4/3]">
                <video x-ref="cameraVideo" autoplay playsinline muted class="w-full h-full object-cover scale-x-[-1]"></video>
                <canvas x-ref="captureCanvas" class="hidden"></canvas>
              </div>
              <button @click="capturePhoto()" :disabled="!cameraActive" class="w-full mt-3 bg-emerald-600 disabled:bg-emerald-300 text-white font-bold py-2.5 rounded-xl">Capture Photo</button>
            </div>

            <div x-show="uploadMode === 'library'" x-cloak>
              <div class="grid grid-cols-3 gap-3">
                <template x-for="model in modelLibrary" :key="model.id">
                  <div @click="selectModelFromLibrary(model)" :class="userImage === model.image ? 'border-2 border-emerald-500' : 'border border-gray-200'" class="rounded-xl overflow-hidden cursor-pointer bg-gray-50">
                    <div class="aspect-[3/4] w-full bg-white"><img :src="model.image" :alt="model.name" class="w-full h-full object-cover"></div>
                    <p class="text-[10px] text-center py-1 truncate" x-text="model.name"></p>
                  </div>
                </template>
              </div>
            </div>
          </div>

          <!-- STEP 2 -->
          <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
              <span class="flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white font-bold text-sm">2</span>
              <h2 class="text-lg font-bold text-gray-800">Select Category</h2>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <template x-for="cat in categories" :key="cat.id">
                <button @click="selectedCategory = cat.id; selectFirstItemOfCategory()"
                  :class="selectedCategory === cat.id ? 'border-emerald-500 bg-emerald-50/50 text-emerald-700 font-bold' : 'border-gray-200 text-gray-600'"
                  class="border rounded-xl p-3 text-xs flex items-center space-x-2">
                  <span class="p-1.5 rounded-lg bg-emerald-100" x-text="cat.icon"></span>
                  <span x-text="cat.name"></span>
                </button>
              </template>
            </div>
          </div>

          <!-- STEP 3 -->
          <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center space-x-3 mb-4">
              <span class="flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white font-bold text-sm">3</span>
              <h2 class="text-lg font-bold text-gray-800">Choose Cap / Item</h2>
            </div>
            <div class="flex space-x-3 overflow-x-auto pb-2">
              <template x-for="item in filteredItems" :key="item.id">
                <div @click="selectItem(item)" :class="selectedItem?.id === item.id ? 'border-2 border-emerald-500 bg-emerald-50/30' : 'border border-gray-200 bg-gray-50'"
                  class="flex-shrink-0 w-28 rounded-xl p-2 cursor-pointer text-center">
                  <div class="w-full h-20 flex items-center justify-center bg-white rounded-lg p-1">
                    <img :src="item.image" class="max-h-full max-w-full object-contain">
                  </div>
                  <p class="text-[11px] mt-2 truncate" x-text="item.name"></p>
                </div>
              </template>
            </div>
          </div>

          <!-- Generate Button -->
          <button @click="generateTryOn()" :disabled="isGeneratingAI"
            class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg flex items-center justify-center space-x-2">
            <svg x-show="!isGeneratingAI" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <svg x-show="isGeneratingAI" class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span x-text="isGeneratingAI ? 'Fitting cap...' : 'Generate (Cap Auto-Fit)'"></span>
          </button>
        </div>

        <!-- RIGHT CANVAS -->
        <div class="lg:col-span-7">
          <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-6">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center space-x-3">
                <span class="flex items-center justify-center w-7 h-7 rounded-full bg-emerald-500 text-white font-bold text-sm">4</span>
                <h2 class="text-lg font-bold text-gray-800">Interactive Canvas</h2>
              </div>
              <div class="flex bg-slate-100 p-1 rounded-xl text-xs font-semibold">
                <button @click="viewMode = 'result'" :class="viewMode === 'result' ? 'bg-white text-emerald-600 shadow' : 'text-gray-500'" class="px-3 py-1.5 rounded-lg">Result</button>
                <button @click="viewMode = 'adjust'; $nextTick(() => { faceData ? autoFitToHead() : setDefaultCapPosition(); })" :class="viewMode === 'adjust' ? 'bg-white text-emerald-600 shadow' : 'text-gray-500'" class="px-3 py-1.5 rounded-lg">Fine-tune Manually</button>
              </div>
            </div>

            <div x-show="generateNotice" x-cloak class="mb-3 bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded-xl px-3 py-2">
              <span x-text="generateNotice"></span>
            </div>

            <!-- ADJUST VIEW -->
            <div x-show="viewMode === 'adjust'" id="canvasViewport"
              class="relative bg-slate-100 rounded-xl overflow-hidden min-h-[500px] flex items-center justify-center border select-none">
              <template x-if="userImage">
                <img id="userBaseImage" :src="userImage" @load="detectFace()" class="max-h-[480px] object-contain" :style="`transform: scale(${canvasZoom})`">
              </template>
              <template x-if="!userImage">
                <div class="text-center p-6 text-gray-400"><p class="text-sm">Pehle photo upload karein.</p></div>
              </template>

              <div id="overlayContainer" x-show="selectedItem" x-cloak class="absolute cursor-move border-2 border-dashed border-emerald-400 z-10"
                :style="`left: ${itemPos.x}px; top: ${itemPos.y}px; width: ${itemPos.w}px; height: ${itemPos.h}px; transform: rotate(${itemPos.rotation}deg) scaleX(${itemPos.flipped ? -1 : 1})`"
                @mousedown="startDrag($event)">
                <template x-if="selectedItem"><img :src="selectedItem.image" class="w-full h-full object-contain pointer-events-none"></template>
                <div class="absolute -top-2 -right-2 w-5 h-5 bg-white border-2 border-emerald-500 rounded-full cursor-nwse-resize shadow" @mousedown.stop="startResize($event)"></div>
                <div class="absolute -bottom-2 -right-2 w-5 h-5 bg-white border-2 border-emerald-500 rounded-full cursor-grab shadow" @mousedown.stop="startRotate($event)"></div>
              </div>

              <div class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/90 rounded-2xl p-1.5 shadow-lg border flex flex-col space-y-2 z-20">
                <button @click="zoomIn()" class="p-2 hover:bg-emerald-50 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" /></svg></button>
                <button @click="zoomOut()" class="p-2 hover:bg-emerald-50 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" /></svg></button>
                <button @click="rotateItem()" class="p-2 hover:bg-emerald-50 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg></button>
                <button @click="flipItem()" class="p-2 hover:bg-emerald-50 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg></button>
              </div>

              <button @click="applyManualPosition()" class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg z-20">Apply Position ✓</button>
            </div>

            <!-- RESULT VIEW -->
            <div x-show="viewMode === 'result'" class="relative bg-slate-100 rounded-xl overflow-hidden min-h-[500px] flex items-center justify-center border">
              <template x-if="finalImage">
                <img :src="finalImage" class="max-h-[480px] object-contain rounded-lg">
              </template>
              <template x-if="!finalImage">
                <div class="text-center p-6 text-gray-400"><p class="text-sm">Generate karein result dekhne ke liye.</p></div>
              </template>
            </div>

            <div class="mt-6 flex items-center space-x-4">
              <button @click="saveAndDownload()" :disabled="!finalImage" class="flex-1 border border-gray-300 hover:border-emerald-500 disabled:opacity-40 font-bold py-3 rounded-xl text-gray-700">Save / Download Result</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- face-api.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('tryOnApp', () => ({
        userImage: null,
        userBase64: null,
        selectedCategory: 'ihram',
        selectedItem: null,
        canvasZoom: 1,
        modelsLoaded: false,
        faceData: null,
        viewMode: 'result',
        isGeneratingAI: false,
        finalImage: null,
        generateNotice: null,
        uploadMode: 'file',
        cameraStream: null,
        cameraActive: false,

        modelLibrary: [
          { id: 1, name: 'Model 1', image: '/images/models/model-1.jpg' },
          { id: 2, name: 'Model 2', image: '/images/models/model-2.jpg' },
          { id: 3, name: 'Model 3', image: '/images/models/model-3.jpg' },
          { id: 4, name: 'Model 4', image: '/images/models/model-4.jpg' },
          { id: 5, name: 'Model 5', image: '/images/models/model-5.jpg' },
          { id: 6, name: 'Model 6', image: '/images/models/model-6.jpg' }
        ],

        itemPos: { x: 100, y: 50, w: 180, h: 120, rotation: 0, flipped: false },

        categories: [
          { id: 'ihram', name: 'Ihram & Caps', icon: '🧢' },
          { id: 'accessories', name: 'Accessories', icon: '👓' }
        ],

        // ⭐ TUNED VALUES — Cap head pe naturally baithe gi (face cover nahi karegi)
        // widthScale: cap width = face width × this
        // heightScale: cap height = face height × this (natural PNG ratio ignore)
        // topOffsetRatio: kitna % cap face ke UPAR ho (0.85 = 85% upar, 15% overlap)
       items: [
  {
    id: 1, category: 'ihram', name: 'Kufi Cap',
    image: '/images/caps/Kufi-removebg-preview.png',
    widthScale: 1.35,        // Wider — head ko sides se cover karegi
    heightScale: 0.75,       // Taller — proper dome shape
    topOffsetRatio: 1.15     // Cap poori upar shift — head ke TOP pe baithe gi
  },
  {
    id: 2, category: 'ihram', name: 'Taqiyah Cap',
    image: '/images/caps/taqiyah-removebg-preview.png',
    widthScale: 1.3,
    heightScale: 0.7,
    topOffsetRatio: 1.18
  },
  {
    id: 3, category: 'ihram', name: 'Amama Turban',
    image: '/images/caps/Amama-removebg-preview.png',
    widthScale: 1.45,
    heightScale: 0.85,
    topOffsetRatio: 1.1
  }
],

        get filteredItems() {
          return this.items.filter(item => item.category === this.selectedCategory);
        },

        async init() {
          this.selectFirstItemOfCategory();
          window.addEventListener('beforeunload', () => this.stopCamera());
          await this.loadFaceApiModels();
        },

        async loadFaceApiModels() {
          const start = Date.now();
          while (typeof faceapi === 'undefined' && Date.now() - start < 8000) {
            await new Promise(r => setTimeout(r, 100));
          }
          if (typeof faceapi === 'undefined') {
            console.warn('⚠️ face-api.js not loaded');
            return;
          }
          try {
            const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api@1.7.13/model';
            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            this.modelsLoaded = true;
            console.log('✅ face-api.js models loaded');
            if (this.userImage) setTimeout(() => this.detectFace(), 300);
          } catch (err) {
            console.error('Model load fail:', err);
          }
        },

        async detectFace() {
          if (!this.modelsLoaded || !this.userImage) return;
          const imgElement = document.getElementById('userBaseImage');
          if (!imgElement || !imgElement.complete || !imgElement.naturalWidth) return;

          try {
            const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.5 });
            const result = await faceapi.detectSingleFace(imgElement, options).withFaceLandmarks();

            if (result) {
              this.faceData = {
                box: result.detection.box,
                landmarks: result.landmarks
              };
              console.log('✅ Face detected — box:', this.faceData.box);
              if (this.viewMode === 'adjust' && this.selectedItem) this.autoFitToHead();
            } else {
              this.faceData = null;
              console.warn('⚠️ No face detected');
            }
          } catch (err) {
            console.error('Detection error:', err);
            this.faceData = null;
          }
        },

        async detectFaceOnRawImage() {
          if (!this.modelsLoaded) return null;
          return new Promise((resolve) => {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = async () => {
              try {
                const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.5 });
                const result = await faceapi.detectSingleFace(img, options).withFaceLandmarks();
                if (result) {
                  resolve({
                    box: result.detection.box,
                    landmarks: result.landmarks,
                    imageWidth: img.naturalWidth,
                    imageHeight: img.naturalHeight
                  });
                } else {
                  resolve(null);
                }
              } catch (err) {
                console.error('Raw detection error:', err);
                resolve(null);
              }
            };
            img.onerror = () => resolve(null);
            img.src = this.userImage;
          });
        },

        switchToFile() { this.stopCamera(); this.uploadMode = 'file'; },
        switchToCamera() { this.stopCamera(); this.uploadMode = 'camera'; this.$nextTick(() => this.startCamera()); },
        switchToModelLibrary() { this.stopCamera(); this.uploadMode = 'library'; },

        selectModelFromLibrary(model) {
          this.userImage = model.image;
          this.userBase64 = null;
          this.faceData = null;
          this.finalImage = null;
          this.generateNotice = null;
          setTimeout(() => this.detectFace(), 400);
        },

        async startCamera() {
          try {
            this.cameraStream = await navigator.mediaDevices.getUserMedia({
              video: { facingMode: 'user', width: { ideal: 720 } }, audio: false
            });
            const video = this.$refs.cameraVideo;
            video.srcObject = this.cameraStream;
            await video.play();
            this.cameraActive = true;
          } catch { alert('Camera denied.'); this.uploadMode = 'file'; }
        },

        capturePhoto() {
          const video = this.$refs.cameraVideo, canvas = this.$refs.captureCanvas;
          if (!video?.videoWidth) return;
          canvas.width = video.videoWidth; canvas.height = video.videoHeight;
          const ctx = canvas.getContext('2d');
          ctx.translate(canvas.width, 0); ctx.scale(-1, 1);
          ctx.drawImage(video, 0, 0);
          const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
          this.userImage = dataUrl; this.userBase64 = dataUrl;
          this.faceData = null; this.finalImage = null; this.generateNotice = null;
          this.stopCamera(); this.uploadMode = 'file';
          setTimeout(() => this.detectFace(), 400);
        },

        stopCamera() {
          if (this.cameraStream) { this.cameraStream.getTracks().forEach(t => t.stop()); this.cameraStream = null; }
          this.cameraActive = false;
        },

        selectFirstItemOfCategory() {
          const f = this.filteredItems[0];
          if (f) this.selectItem(f);
        },

        selectItem(item) {
          this.selectedItem = item;
          this.$nextTick(() => {
            if (this.faceData) this.autoFitToHead();
            else this.setDefaultCapPosition();
          });
        },

        setDefaultCapPosition() {
          const vp = document.getElementById('canvasViewport');
          const rW = vp ? vp.clientWidth : 400, rH = vp ? vp.clientHeight : 500;
          const cw = rW * 0.35, ch = cw * 0.55;
          this.itemPos = { x: (rW / 2) - (cw / 2), y: rH * 0.08, w: cw, h: ch, rotation: 0, flipped: false };
        },

        // ⭐ FIXED: Uses controlled height (not PNG natural ratio)
        autoFitToHead() {
          if (!this.faceData || !this.selectedItem) return;
          const imgEl = document.getElementById('userBaseImage');
          const vp = document.getElementById('canvasViewport');
          if (!imgEl || !vp) return;

          const imgRect = imgEl.getBoundingClientRect();
          const vpRect = vp.getBoundingClientRect();
          const renderW = imgRect.width, renderH = imgRect.height;
          const offX = imgRect.left - vpRect.left, offY = imgRect.top - vpRect.top;

          const scaleX = renderW / imgEl.naturalWidth;
          const scaleY = renderH / imgEl.naturalHeight;

          const box = this.faceData.box;
          const faceX = box.x * scaleX;
          const faceY = box.y * scaleY;
          const faceW = box.width * scaleX;
          const faceH = box.height * scaleY;

          const it = this.selectedItem;
          const capW = faceW * (it.widthScale || 1.15);
          const capH = faceH * (it.heightScale || 0.55);
          const topOffsetRatio = it.topOffsetRatio || 0.85;

          const capCenterX = offX + faceX + faceW / 2;
          const capTop = offY + faceY - (capH * topOffsetRatio);

          this.itemPos = {
            x: capCenterX - capW / 2,
            y: capTop,
            w: capW,
            h: capH,
            rotation: 0,
            flipped: false
          };
        },

        handleFileUpload(e) {
          const file = e.target.files[0];
          if (!file) return;
          const r = new FileReader();
          r.onload = (ev) => {
            this.userImage = ev.target.result;
            this.userBase64 = ev.target.result;
            this.faceData = null;
            this.finalImage = null;
            this.generateNotice = null;
            setTimeout(() => this.detectFace(), 400);
          };
          r.readAsDataURL(file);
        },

        async generateTryOn() {
          if (!this.userImage) { alert('Photo upload karein.'); return; }
          if (!this.selectedItem) { alert('Cap select karein.'); return; }

          this.isGeneratingAI = true;
          this.finalImage = null;
          this.generateNotice = null;

          try {
            let detection = null;
            if (this.modelsLoaded) {
              detection = await this.detectFaceOnRawImage();
            }

            let composed;
            if (detection) {
              composed = await this.composeFromDetection(detection);
            } else {
              composed = await this.composeWithDefaultPosition();
              this.generateNotice = 'Face detect nahi hua — approximate positioning use hui. "Fine-tune Manually" se adjust karein.';
            }
            this.finalImage = composed;
            this.viewMode = 'result';
          } catch (err) {
            console.error('Generate error:', err);
            alert('Result banate waqt error aaya.');
          } finally {
            this.isGeneratingAI = false;
          }
        },

        // ⭐ FIXED: Cap head pe naturally baithe gi
        composeFromDetection(det) {
          return new Promise((resolve, reject) => {
            const userImg = new Image();
            userImg.crossOrigin = 'anonymous';
            userImg.onload = () => {
              const capImg = new Image();
              capImg.crossOrigin = 'anonymous';
              capImg.onload = () => {
                try {
                  const canvas = document.createElement('canvas');
                  canvas.width = userImg.naturalWidth;
                  canvas.height = userImg.naturalHeight;
                  const ctx = canvas.getContext('2d');
                  ctx.drawImage(userImg, 0, 0);

                  const it = this.selectedItem;
                  const box = det.box;
                  const faceW = box.width;
                  const faceH = box.height;
                  const faceTop = box.y;
                  const faceCenterX = box.x + faceW / 2;

                  // Controlled size — NO natural PNG ratio
                  const capW = faceW * (it.widthScale || 1.15);
                  const capH = faceH * (it.heightScale || 0.55);

                  // Cap top = face top - (85% of cap height)
                  // Matlab cap ka 85% face ke UPAR + 15% overlap face pe
                  const topOffsetRatio = it.topOffsetRatio || 0.85;
                  const capTop = faceTop - (capH * topOffsetRatio);

                  ctx.drawImage(
                    capImg,
                    faceCenterX - capW / 2,
                    capTop,
                    capW,
                    capH
                  );

                  resolve(canvas.toDataURL('image/jpeg', 0.92));
                } catch (e) { reject(e); }
              };
              capImg.onerror = () => reject(new Error('Cap load fail'));
              capImg.src = this.selectedItem.image;
            };
            userImg.onerror = () => reject(new Error('Photo load fail'));
            userImg.src = this.userImage;
          });
        },

        composeWithDefaultPosition() {
          return new Promise((resolve, reject) => {
            const userImg = new Image();
            userImg.crossOrigin = 'anonymous';
            userImg.onload = () => {
              const capImg = new Image();
              capImg.crossOrigin = 'anonymous';
              capImg.onload = () => {
                try {
                  const canvas = document.createElement('canvas');
                  canvas.width = userImg.naturalWidth;
                  canvas.height = userImg.naturalHeight;
                  const ctx = canvas.getContext('2d');
                  ctx.drawImage(userImg, 0, 0);

                  const it = this.selectedItem;
                  // Assume face is ~40% of image width, centered, top ~20%
                  const assumedFaceW = canvas.width * 0.4;
                  const assumedFaceH = assumedFaceW * 1.3;
                  const assumedFaceTop = canvas.height * 0.2;
                  const assumedFaceCenterX = canvas.width / 2;

                  const capW = assumedFaceW * (it.widthScale || 1.15);
                  const capH = assumedFaceH * (it.heightScale || 0.55);
                  const topOffsetRatio = it.topOffsetRatio || 0.85;
                  const capTop = assumedFaceTop - (capH * topOffsetRatio);

                  ctx.drawImage(
                    capImg,
                    assumedFaceCenterX - capW / 2,
                    Math.max(capTop, 5),
                    capW,
                    capH
                  );

                  resolve(canvas.toDataURL('image/jpeg', 0.92));
                } catch (e) { reject(e); }
              };
              capImg.onerror = () => reject(new Error('Cap load fail'));
              capImg.src = this.selectedItem.image;
            };
            userImg.onerror = () => reject(new Error('Photo load fail'));
            userImg.src = this.userImage;
          });
        },

        applyManualPosition() {
          const imgEl = document.getElementById('userBaseImage');
          const vp = document.getElementById('canvasViewport');
          if (!imgEl || !vp || !this.selectedItem) return;
          this.isGeneratingAI = true;

          const iR = imgEl.getBoundingClientRect(), vR = vp.getBoundingClientRect();
          const sX = imgEl.naturalWidth / iR.width, sY = imgEl.naturalHeight / iR.height;
          const oL = iR.left - vR.left, oT = iR.top - vR.top;
          const rX = (this.itemPos.x - oL) * sX, rY = (this.itemPos.y - oT) * sY;
          const cW = this.itemPos.w * sX, cH = this.itemPos.h * sY;
          const cX = rX + cW / 2, cY = rY + cH / 2;

          const uImg = new Image(); uImg.crossOrigin = 'anonymous';
          uImg.onload = () => {
            const cImg = new Image(); cImg.crossOrigin = 'anonymous';
            cImg.onload = () => {
              const canvas = document.createElement('canvas');
              canvas.width = uImg.naturalWidth; canvas.height = uImg.naturalHeight;
              const ctx = canvas.getContext('2d');
              ctx.drawImage(uImg, 0, 0);
              ctx.save();
              ctx.translate(cX, cY);
              ctx.rotate(this.itemPos.rotation * Math.PI / 180);
              ctx.scale(this.itemPos.flipped ? -1 : 1, 1);
              ctx.drawImage(cImg, -cW / 2, -cH / 2, cW, cH);
              ctx.restore();
              this.finalImage = canvas.toDataURL('image/jpeg', 0.92);
              this.viewMode = 'result';
              this.isGeneratingAI = false;
            };
            cImg.onerror = () => { this.isGeneratingAI = false; };
            cImg.src = this.selectedItem.image;
          };
          uImg.onerror = () => { this.isGeneratingAI = false; };
          uImg.src = this.userImage;
        },

        async saveAndDownload() {
          if (!this.finalImage) return;
          const link = document.createElement('a');
          link.href = this.finalImage;
          link.download = 'meeqat-tryon-' + Date.now() + '.jpg';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);

          try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
              await fetch('/tryon/save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ result_image: this.finalImage })
              });
            }
          } catch (e) { console.warn('Save skipped:', e); }
        },

        zoomIn() { if (this.canvasZoom < 1.4) this.canvasZoom += 0.1; },
        zoomOut() { if (this.canvasZoom > 0.7) this.canvasZoom -= 0.1; },
        rotateItem() { this.itemPos.rotation = (this.itemPos.rotation + 15) % 360; },
        flipItem() { this.itemPos.flipped = !this.itemPos.flipped; },

        startDrag(e) {
          let sx = e.clientX - this.itemPos.x, sy = e.clientY - this.itemPos.y;
          const m = (me) => { this.itemPos.x = me.clientX - sx; this.itemPos.y = me.clientY - sy; };
          const u = () => { window.removeEventListener('mousemove', m); window.removeEventListener('mouseup', u); };
          window.addEventListener('mousemove', m); window.addEventListener('mouseup', u);
        },
        startResize(e) {
          let sW = this.itemPos.w, ar = this.itemPos.h / this.itemPos.w, sx = e.clientX;
          const m = (me) => { let nw = sW + (me.clientX - sx); if (nw > 50) { this.itemPos.w = nw; this.itemPos.h = nw * ar; } };
          const u = () => { window.removeEventListener('mousemove', m); window.removeEventListener('mouseup', u); };
          window.addEventListener('mousemove', m); window.addEventListener('mouseup', u);
        },
        startRotate(e) {
          const r = document.getElementById('overlayContainer').getBoundingClientRect();
          const cx = r.left + r.width / 2, cy = r.top + r.height / 2;
          const m = (me) => { this.itemPos.rotation = Math.atan2(me.clientY - cy, me.clientX - cx) * (180 / Math.PI); };
          const u = () => { window.removeEventListener('mousemove', m); window.removeEventListener('mouseup', u); };
          window.addEventListener('mousemove', m); window.addEventListener('mouseup', u);
        }
      }));
    });
  </script>
@endsection