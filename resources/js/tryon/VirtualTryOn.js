// resources/js/tryon/VirtualTryOn.js

import { CAP_CONFIGS, getCapConfig } from "./capConfigs.js";
import FaceDetector from "./FaceDetector.js";
import CameraController from "./CameraController.js";
import ImageProcessor from "./ImageProcessor.js";
import CapRenderer from "./CapRenderer.js";
import TrackingEngine from "./TrackingEngine.js";
import AIAdjustmentService from "./AIAdjustmentService.js";

export default function VirtualTryOn() {
    return {
        // ─── State ───
        caps: CAP_CONFIGS,
        selectedCap: null,
        cameraActive: false,
        cameras: [],

        // Cap transform (bound to UI)
        capX: 50,
        capY: 18,
        capWidth: 220,
        capScale: 1,
        capOpacity: 1,
        capRotation: 0,

        // Cap dragging
        capDragging: false,
        _capDragStartX: 0,
        _capDragStartY: 0,
        _capStartPctX: 0,
        _capStartPctY: 0,

        // Cap resizing
        _resizing: false,
        _resizeCorner: null,
        _resizeStartX: 0,
        _resizeStartY: 0,
        _resizeStartW: 0,

        // Image upload state
        uploadedImage: null,
        imgX: 0,
        imgY: 0,
        imgScale: 1,
        imgDragging: false,
        _imgDragStartX: 0,
        _imgDragStartY: 0,
        _imgPanStartX: 0,
        _imgPanStartY: 0,

        // Capture
        capturedImage: null,

        // AI
        aiPrompt: "",
        aiBusy: false,
        aiMessage: "",

        // Face tracking
        _faceDetected: false,
        _autoTracking: false,

        // Internal instances
        _faceDetector: null,
        _cameraCtrl: null,
        _imageProcessor: null,
        _capRenderer: null,
        _trackingEngine: null,
        _aiService: null,

        // ─── Lifecycle ───
        async init() {
            console.log("[VirtualTryOn] Initializing...");

            // Create instances
            this._faceDetector = new FaceDetector();
            this._cameraCtrl = new CameraController();
            this._imageProcessor = new ImageProcessor();
            this._capRenderer = new CapRenderer();
            this._aiService = new AIAdjustmentService();

            // Preload cap images
            await this._capRenderer.preloadAll(CAP_CONFIGS);

            // Enumerate cameras
            try {
                await this._cameraCtrl.enumerateCameras();
                this.cameras = this._cameraCtrl.cameras;
            } catch (e) {
                // Cameras not available — that's fine
            }

            // Initialize face detector in background
            this._faceDetector.init().catch((err) => {
                console.warn(
                    "[VirtualTryOn] Face detector init failed (will retry):",
                    err.message,
                );
            });

            // Set up keyboard controls
            this._setupKeyboard();

            console.log("[VirtualTryOn] Ready ✓");
        },

        destroy() {
            this._stopTracking();
            if (this._cameraCtrl) this._cameraCtrl.destroy();
            if (this._faceDetector) this._faceDetector.destroy();
            if (this._trackingEngine) this._trackingEngine.destroy();
        },

        // ─── Camera ───
        async startCamera() {
            try {
                const videoEl = this.$refs.video;
                await this._cameraCtrl.start(videoEl);
                this.cameraActive = true;
                this.cameras = this._cameraCtrl.cameras;
                this.uploadedImage = null;
                this._imageProcessor.resetTransform();

                // Start face tracking if a cap is selected
                if (this.selectedCap) {
                    await this._startTracking();
                }
            } catch (err) {
                alert(
                    "Camera access denied or unavailable. Please check permissions.",
                );
                console.error(err);
            }
        },

        stopCamera() {
            this._stopTracking();
            this._cameraCtrl.stop();
            this.cameraActive = false;
        },

        async switchCamera() {
            if (this.cameras.length < 2) return;
            this._stopTracking();

            try {
                await this._cameraCtrl.switchCamera(this.$refs.video);
                this.cameras = this._cameraCtrl.cameras;

                if (this.selectedCap) {
                    await this._startTracking();
                }
            } catch (err) {
                console.error("Switch camera failed:", err);
            }
        },

        // ─── Upload ───
        async uploadPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;

            try {
                // Stop camera if active
                if (this.cameraActive) {
                    this.stopCamera();
                }

                const dataUrl = await this._imageProcessor.loadFile(file);
                this.uploadedImage = dataUrl;
                this.imgX = 0;
                this.imgY = 0;
                this.imgScale = 1;

                // Auto-detect face if cap is selected
                if (this.selectedCap) {
                    // Small delay to let the image render in DOM
                    await this.$nextTick();
                    setTimeout(() => this.autoFitCap(), 300);
                }
            } catch (err) {
                alert("Failed to load image. Please try another file.");
                console.error(err);
            }

            // Reset file input so the same file can be re-selected
            event.target.value = "";
        },

        // ─── Image Pan/Zoom ───
        startImageDrag(event) {
            this.imgDragging = true;
            this._imgDragStartX = event.clientX;
            this._imgDragStartY = event.clientY;
            this._imgPanStartX = this.imgX;
            this._imgPanStartY = this.imgY;
            event.target.setPointerCapture(event.pointerId);
        },

        onImageDrag(event) {
            if (!this.imgDragging) return;
            this.imgX =
                this._imgPanStartX + (event.clientX - this._imgDragStartX);
            this.imgY =
                this._imgPanStartY + (event.clientY - this._imgDragStartY);
        },

        endImageDrag() {
            this.imgDragging = false;
        },

        zoomImage(factor) {
            this.imgScale = Math.max(0.3, Math.min(4, this.imgScale * factor));
        },

        resetImage() {
            this.imgX = 0;
            this.imgY = 0;
            this.imgScale = 1;
        },

        // ─── Cap Selection ───
        async selectCap(id) {
            const wasSelected = this.selectedCap;
            this.selectedCap = id;

            const config = getCapConfig(id);
            this.capWidth = config.defaultW;
            this.capScale = config.defaultS;
            this.capY = config.defaultY;
            this.capX = 50;
            this.capOpacity = 1;
            this.capRotation = 0;

            // Start/restart tracking if camera is on
            if (this.cameraActive) {
                if (this._trackingEngine && this._trackingEngine.running) {
                    this._trackingEngine.setCapId(id);
                } else {
                    await this._startTracking();
                }
            } else if (this.uploadedImage && this._imageProcessor.image) {
                const img = this._imageProcessor.image;
                ctx.save();
                ctx.translate(viewW / 2 + this.imgX, viewH / 2 + this.imgY);
                ctx.scale(this.imgScale, this.imgScale);

                const imgAspect = img.naturalWidth / img.naturalHeight;
                const viewAspect = viewW / viewH;
                let drawW, drawH;
                if (imgAspect > viewAspect) {
                    drawH = viewH;
                    drawW = viewH * imgAspect;
                } else {
                    drawW = viewW;
                    drawH = viewW / imgAspect;
                }
                ctx.drawImage(img, -drawW / 2, -drawH / 2, drawW, drawH);
                ctx.restore();
            }
        },

        // ─── Cap Dragging (Manual) ───
        startCapDrag(event) {
            // Disable auto-tracking when user manually drags
            this._autoTracking = false;
            if (this._trackingEngine) this._trackingEngine.stop();

            this.capDragging = true;
            this._capDragStartX = event.clientX;
            this._capDragStartY = event.clientY;
            this._capStartPctX = this.capX;
            this._capStartPctY = this.capY;

            // Global listeners for drag
            const onMove = (e) => this._onCapDragMove(e);
            const onUp = () => {
                this.capDragging = false;
                window.removeEventListener("pointermove", onMove);
                window.removeEventListener("pointerup", onUp);
            };

            window.addEventListener("pointermove", onMove);
            window.addEventListener("pointerup", onUp);
        },

        _onCapDragMove(event) {
            if (!this.capDragging) return;

            const viewport = this.$refs.video?.parentElement;
            if (!viewport) return;

            const rect = viewport.getBoundingClientRect();
            const deltaX =
                ((event.clientX - this._capDragStartX) / rect.width) * 100;
            const deltaY =
                ((event.clientY - this._capDragStartY) / rect.height) * 100;

            this.capX = Math.max(5, Math.min(95, this._capStartPctX + deltaX));
            this.capY = Math.max(0, Math.min(80, this._capStartPctY + deltaY));
        },

        // ─── Cap Resize (Corner handles) ───
        startResize(event, corner) {
            this._resizing = true;
            this._resizeCorner = corner;
            this._resizeStartX = event.clientX;
            this._resizeStartY = event.clientY;
            this._resizeStartW = this.capWidth;

            const onMove = (e) => this._onResizeMove(e);
            const onUp = () => {
                this._resizing = false;
                this._resizeCorner = null;
                window.removeEventListener("pointermove", onMove);
                window.removeEventListener("pointerup", onUp);
            };

            window.addEventListener("pointermove", onMove);
            window.addEventListener("pointerup", onUp);
        },

        _onResizeMove(event) {
            if (!this._resizing) return;

            const deltaX = event.clientX - this._resizeStartX;
            const deltaY = event.clientY - this._resizeStartY;

            // Average of both axes for uniform scale
            let delta = 0;
            switch (this._resizeCorner) {
                case "se":
                    delta = (deltaX + deltaY) / 2;
                    break;
                case "sw":
                    delta = (-deltaX + deltaY) / 2;
                    break;
                case "ne":
                    delta = (deltaX - deltaY) / 2;
                    break;
                case "nw":
                    delta = (-deltaX - deltaY) / 2;
                    break;
            }

            this.capWidth = Math.max(
                60,
                Math.min(500, this._resizeStartW + delta),
            );
        },

        // ─── Face Tracking ───
        async _startTracking() {
            // Ensure detector is ready
            if (!this._faceDetector.ready) {
                try {
                    await this._faceDetector.init();
                } catch (e) {
                    console.warn("[VirtualTryOn] Face detector not available");
                    return;
                }
            }

            // Create tracking engine
            if (this._trackingEngine) {
                this._trackingEngine.stop();
            }

            this._trackingEngine = new TrackingEngine(
                this._faceDetector,
                this._capRenderer,
            );

            // Get viewport size
            const viewport = this.$refs.video?.parentElement;
            const viewW = viewport?.clientWidth || 640;
            const viewH = viewport?.clientHeight || 480;

            // Set callbacks
            this._trackingEngine.onFaceUpdate = (faceData, placement) => {
                if (!this._autoTracking) return; // Respect manual override
                this._faceDetected = true;

                // Update Alpine state from tracking
                this.capX = placement.xPercent;
                this.capY = placement.yPercent;
                this.capWidth = placement.width;
                this.capRotation = Math.round(placement.rotation * 10) / 10;
            };

            this._trackingEngine.onNoFace = () => {
                this._faceDetected = false;
            };

            this._autoTracking = true;
            this._trackingEngine.start(
                this.$refs.video,
                this.selectedCap,
                viewW,
                viewH,
            );
        },

        _stopTracking() {
            this._autoTracking = false;
            if (this._trackingEngine) {
                this._trackingEngine.stop();
            }
        },

        // ─── Auto-Fit (for uploaded images) ───
        // ─── Auto-Fit (for uploaded images) ───
        async autoFitCap() {
            if (!this.selectedCap) return;
            if (!this.uploadedImage && !this.cameraActive) return;

            this.aiBusy = true;
            this.aiMessage = "Detecting face...";

            try {
                if (!this._faceDetector.ready) {
                    await this._faceDetector.init();
                }

                let faceData = null;
                let viewW, viewH;

                if (this.uploadedImage) {
                    // Get viewport dimensions
                    const viewport = this.$refs.video?.parentElement;
                    viewW = viewport?.clientWidth || 640;
                    viewH = viewport?.clientHeight || 480;

                    // Detect face on the ORIGINAL image (not a canvas)
                    const img = this._imageProcessor.image;
                    if (!img) throw new Error("Image not loaded");

                    faceData = await this._faceDetector.detectImage(img);

                    if (faceData) {
                        // Face landmarks are normalized to the ORIGINAL image (0-1)
                        // We need to map them into VIEWPORT coordinates, accounting for:
                        //   1. object-fit: contain (letterboxing)
                        //   2. User's pan (imgX, imgY) and zoom (imgScale)

                        const imgW = img.naturalWidth;
                        const imgH = img.naturalHeight;
                        const imgAspect = imgW / imgH;
                        const viewAspect = viewW / viewH;

                        // How the image fits inside the viewport (object-fit: contain)
                        let renderedW, renderedH, offsetX, offsetY;
                        if (imgAspect > viewAspect) {
                            // Image is wider — fit to viewport width
                            renderedW = viewW;
                            renderedH = viewW / imgAspect;
                            offsetX = 0;
                            offsetY = (viewH - renderedH) / 2;
                        } else {
                            // Image is taller — fit to viewport height
                            renderedH = viewH;
                            renderedW = viewH * imgAspect;
                            offsetX = (viewW - renderedW) / 2;
                            offsetY = 0;
                        }

                        // Apply user's pan + zoom (transform origin is center)
                        const scale = this.imgScale;
                        const finalW = renderedW * scale;
                        const finalH = renderedH * scale;
                        // Center of viewport + user's pan
                        const centerX = viewW / 2 + this.imgX;
                        const centerY = viewH / 2 + this.imgY;
                        const finalOffsetX = centerX - finalW / 2;
                        const finalOffsetY = centerY - finalH / 2;

                        // Rebuild a "face data" object with viewport-mapped coordinates
                        const mappedFaceData = this._mapFaceToViewport(
                            faceData,
                            finalOffsetX,
                            finalOffsetY,
                            finalW,
                            finalH,
                            viewW,
                            viewH,
                        );

                        const placement = this._capRenderer.calculatePlacement(
                            mappedFaceData,
                            this.selectedCap,
                            viewW,
                            viewH,
                            false, // Uploaded images are NOT mirrored
                        );

                        if (placement) {
                            this.capX =
                                Math.round(placement.xPercent * 10) / 10;
                            this.capY =
                                Math.round(placement.yPercent * 10) / 10;
                            this.capWidth = Math.max(
                                60,
                                Math.min(500, Math.round(placement.width)),
                            );
                            this.capRotation = Math.round(placement.rotation);
                            this.capScale = 1;
                            this.capOpacity = 1;

                            console.log("[AutoFit] Placement:", placement);
                            this.aiMessage = "✓ Cap fitted to your head!";
                            this._faceDetected = true;
                        } else {
                            this.aiMessage = "⚠ Could not calculate placement";
                        }
                    } else {
                        this.aiMessage =
                            "⚠ No face detected. Try a clearer photo.";
                        this._faceDetected = false;
                    }
                } else if (this.cameraActive) {
                    const video = this.$refs.video;
                    viewW = video.parentElement?.clientWidth || 640;
                    viewH = video.parentElement?.clientHeight || 480;

                    const timestamp = performance.now();
                    faceData = this._faceDetector.detectVideo(video, timestamp);

                    if (faceData) {
                        const placement = this._capRenderer.calculatePlacement(
                            faceData,
                            this.selectedCap,
                            viewW,
                            viewH,
                            true, // Camera IS mirrored
                        );

                        if (placement) {
                            this.capX =
                                Math.round(placement.xPercent * 10) / 10;
                            this.capY =
                                Math.round(placement.yPercent * 10) / 10;
                            this.capWidth = Math.max(
                                60,
                                Math.min(500, Math.round(placement.width)),
                            );
                            this.capRotation = Math.round(placement.rotation);
                            this.capScale = 1;
                            this.capOpacity = 1;

                            this.aiMessage = "✓ Cap fitted to your head!";
                            this._faceDetected = true;
                        }
                    } else {
                        this.aiMessage = "⚠ No face detected in camera.";
                        this._faceDetected = false;
                    }
                }
            } catch (err) {
                console.error("[AutoFit] Error:", err);
                this.aiMessage = "⚠ Face detection failed. Try again.";
            } finally {
                this.aiBusy = false;
                setTimeout(() => {
                    this.aiMessage = "";
                }, 4000);
            }
        },

        /**
         * Map face landmarks from image-normalized (0-1) coords to viewport coords.
         * Returns a new faceData object with all positions re-normalized to the viewport.
         */
        _mapFaceToViewport(
            faceData,
            imgOffsetX,
            imgOffsetY,
            imgW,
            imgH,
            viewW,
            viewH,
        ) {
            // Convert an image-normalized point → viewport-normalized point
            const map = (pt) => {
                const pxInImage_x = pt.x * imgW;
                const pxInImage_y = pt.y * imgH;
                const pxInView_x = imgOffsetX + pxInImage_x;
                const pxInView_y = imgOffsetY + pxInImage_y;
                return {
                    x: pxInView_x / viewW,
                    y: pxInView_y / viewH,
                };
            };

            const crown = map(faceData.crown);
            const chin = map(faceData.chin);
            const leftEar = map(faceData.leftEar);
            const rightEar = map(faceData.rightEar);
            const foreheadCtr = map(faceData.foreheadCenter);

            return {
                ...faceData,
                crown,
                chin,
                leftEar,
                rightEar,
                foreheadCenter: foreheadCtr,
                headWidth: Math.abs(rightEar.x - leftEar.x),
                headHeight: Math.abs(chin.y - crown.y),
                headCenter: {
                    x: (leftEar.x + rightEar.x) / 2,
                    y: (crown.y + chin.y) / 2,
                },
                frameW: viewW,
                frameH: viewH,
            };
        },

        // ─── AI Text Prompt ───
        async runAiAdjust() {
            if (!this.aiPrompt.trim() || this.aiBusy) return;

            this.aiBusy = true;

            // Simulate brief processing
            await new Promise((r) => setTimeout(r, 300));

            const result = this._aiService.parse(this.aiPrompt, {
                capX: this.capX,
                capY: this.capY,
                capWidth: this.capWidth,
                capScale: this.capScale,
                capRotation: this.capRotation,
                capOpacity: this.capOpacity,
            });

            // Handle special flags
            if (result._reset) {
                const config = getCapConfig(this.selectedCap);
                this.capX = 50;
                this.capY = config.defaultY;
                this.capWidth = config.defaultW;
                this.capScale = config.defaultS;
                this.capRotation = 0;
                this.capOpacity = 1;
            } else if (result._autoFit) {
                this.aiBusy = false;
                this.aiPrompt = "";
                await this.autoFitCap();
                return;
            } else {
                // Apply adjustments
                this.capX = result.capX;
                this.capY = result.capY;
                this.capWidth = result.capWidth;
                this.capScale = result.capScale;
                this.capRotation = result.capRotation;
                this.capOpacity = result.capOpacity;
            }

            this.aiMessage = result.message;
            this.aiPrompt = "";
            this.aiBusy = false;

            setTimeout(() => {
                this.aiMessage = "";
            }, 4000);
        },

        // ─── Capture Photo ───
        capturePhoto() {
            const viewport =
                this.$refs.video?.parentElement ||
                this.$refs.canvas?.parentElement;
            if (!viewport) return;

            const viewW = viewport.clientWidth;
            const viewH = viewport.clientHeight;

            // Create high-res canvas
            const canvas = document.createElement("canvas");
            const dpr = window.devicePixelRatio || 1;
            canvas.width = viewW * dpr;
            canvas.height = viewH * dpr;
            const ctx = canvas.getContext("2d");
            ctx.scale(dpr, dpr);

            // Step 1: Draw background (camera or uploaded image)
            if (this.cameraActive && this.$refs.video) {
                const video = this.$refs.video;

                // Mirror for front camera
                ctx.save();
                ctx.translate(viewW, 0);
                ctx.scale(-1, 1);

                // Cover-fit the video
                const videoAspect = video.videoWidth / video.videoHeight;
                const viewAspect = viewW / viewH;
                let sx = 0,
                    sy = 0,
                    sw = video.videoWidth,
                    sh = video.videoHeight;

                if (videoAspect > viewAspect) {
                    sw = video.videoHeight * viewAspect;
                    sx = (video.videoWidth - sw) / 2;
                } else {
                    sh = video.videoWidth / viewAspect;
                    sy = (video.videoHeight - sh) / 2;
                }

                ctx.drawImage(video, sx, sy, sw, sh, 0, 0, viewW, viewH);
                ctx.restore();
            } else if (this.uploadedImage && this._imageProcessor.image) {
                const img = this._imageProcessor.image;
                ctx.save();
                ctx.translate(viewW / 2 + this.imgX, viewH / 2 + this.imgY);
                ctx.scale(this.imgScale, this.imgScale);

                // object-fit: contain math (letterbox to show full image)
                const imgAspect = img.naturalWidth / img.naturalHeight;
                const viewAspect = viewW / viewH;
                let drawW, drawH;
                if (imgAspect > viewAspect) {
                    drawW = viewW;
                    drawH = viewW / imgAspect;
                } else {
                    drawH = viewH;
                    drawW = viewH * imgAspect;
                }
                ctx.drawImage(img, -drawW / 2, -drawH / 2, drawW, drawH);
                ctx.restore();
            }

            // Step 2: Draw cap overlay
            if (this.selectedCap) {
                const capImg = this._capRenderer.capImages[this.selectedCap];
                if (capImg) {
                    const centerX = (this.capX / 100) * viewW;
                    const centerY = (this.capY / 100) * viewH;

                    ctx.save();
                    ctx.globalAlpha = parseFloat(this.capOpacity);
                    ctx.translate(centerX, centerY);
                    ctx.rotate((this.capRotation * Math.PI) / 180);
                    ctx.scale(
                        parseFloat(this.capScale),
                        parseFloat(this.capScale),
                    );

                    const w = parseFloat(this.capWidth);
                    const h = w * (capImg.naturalHeight / capImg.naturalWidth);

                    ctx.drawImage(capImg, -w / 2, -h / 2, w, h);
                    ctx.restore();
                }
            }

            // Export
            this.capturedImage = canvas.toDataURL("image/jpeg", 0.92);
            console.log("[Capture] Photo saved ✓");
        },

        // ─── Keyboard Controls ───
        _setupKeyboard() {
            document.addEventListener("keydown", (e) => {
                // Only handle when our component is visible
                if (!this.selectedCap) return;
                if (!this.cameraActive && !this.uploadedImage) return;

                const step = e.shiftKey ? 0.5 : 1;
                const ctrlStep = e.shiftKey ? 2 : 5;
                let handled = false;

                // Ctrl + Arrow = pan the uploaded image
                if (e.ctrlKey && this.uploadedImage && !this.cameraActive) {
                    switch (e.key) {
                        case "ArrowUp":
                            this.imgY -= ctrlStep;
                            handled = true;
                            break;
                        case "ArrowDown":
                            this.imgY += ctrlStep;
                            handled = true;
                            break;
                        case "ArrowLeft":
                            this.imgX -= ctrlStep;
                            handled = true;
                            break;
                        case "ArrowRight":
                            this.imgX += ctrlStep;
                            handled = true;
                            break;
                        case "+":
                        case "=":
                            this.zoomImage(1.1);
                            handled = true;
                            break;
                        case "-":
                        case "_":
                            this.zoomImage(0.9);
                            handled = true;
                            break;
                    }
                }
                // Arrow keys = move cap
                else if (!e.ctrlKey && !e.metaKey) {
                    switch (e.key) {
                        case "ArrowUp":
                            this.capY = Math.max(0, this.capY - step);
                            this._autoTracking = false;
                            handled = true;
                            break;
                        case "ArrowDown":
                            this.capY = Math.min(80, this.capY + step);
                            this._autoTracking = false;
                            handled = true;
                            break;
                        case "ArrowLeft":
                            this.capX = Math.max(5, this.capX - step);
                            this._autoTracking = false;
                            handled = true;
                            break;
                        case "ArrowRight":
                            this.capX = Math.min(95, this.capX + step);
                            this._autoTracking = false;
                            handled = true;
                            break;
                    }
                }

                if (handled) {
                    e.preventDefault();
                }
            });
        },
    };
}
