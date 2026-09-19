// resources/js/tryon/TrackingEngine.js

export default class TrackingEngine {
    constructor(faceDetector, capRenderer) {
        this.faceDetector = faceDetector;
        this.capRenderer = capRenderer;
        this.running = false;
        this.animFrameId = null;
        this.onFaceUpdate = null;   // Callback(faceData, placement)
        this.onNoFace = null;       // Callback()

        // Smoothing state
        this._prev = null;
        this._smoothFactor = 0.35; // Lower = smoother but more lag
    }

    /**
     * Start the real-time tracking loop
     * @param {HTMLVideoElement} video
     * @param {string} capId - which cap to track
     * @param {number} viewW
     * @param {number} viewH
     */
    start(video, capId, viewW, viewH) {
        this.running = true;
        this._video = video;
        this._capId = capId;
        this._viewW = viewW;
        this._viewH = viewH;
        this._prev = null;

        console.log('[TrackingEngine] Started');
        this._tick();
    }

    /**
     * Update which cap we're tracking (no restart needed)
     */
    setCapId(capId) {
        this._capId = capId;
    }

    /**
     * Update viewport dimensions
     */
    setViewport(w, h) {
        this._viewW = w;
        this._viewH = h;
    }

    /**
     * Internal animation loop
     */
    _tick() {
        if (!this.running) return;

        this.animFrameId = requestAnimationFrame(() => {
            if (!this.running) return;

            const video = this._video;

            if (video && video.readyState >= 2 && this.faceDetector.ready) {
                const timestamp = performance.now();
                const faceData = this.faceDetector.detectVideo(video, timestamp);

                if (faceData && this._capId) {
                    const placement = this.capRenderer.calculatePlacement(
                        faceData,
                        this._capId,
                        this._viewW,
                        this._viewH,
                        true // mirrored for front camera
                    );

                    // Smooth the placement
                    const smoothed = this._smooth(placement);

                    if (this.onFaceUpdate) {
                        this.onFaceUpdate(faceData, smoothed);
                    }
                } else {
                    if (this.onNoFace) {
                        this.onNoFace();
                    }
                }
            }

            this._tick();
        });
    }

    /**
     * Smooth placement values to reduce jitter
     */
    _smooth(placement) {
        if (!placement) return this._prev;

        if (!this._prev) {
            this._prev = { ...placement };
            return placement;
        }

        const f = this._smoothFactor;
        const smoothed = {
            x: this._lerp(this._prev.x, placement.x, f),
            y: this._lerp(this._prev.y, placement.y, f),
            width: this._lerp(this._prev.width, placement.width, f),
            height: this._lerp(this._prev.height, placement.height, f),
            rotation: this._lerp(this._prev.rotation, placement.rotation, f),
            xPercent: this._lerp(this._prev.xPercent, placement.xPercent, f),
            yPercent: this._lerp(this._prev.yPercent, placement.yPercent, f),
        };

        this._prev = smoothed;
        return smoothed;
    }

    _lerp(a, b, t) {
        return a + (b - a) * t;
    }

    /**
     * Stop tracking
     */
    stop() {
        this.running = false;
        if (this.animFrameId) {
            cancelAnimationFrame(this.animFrameId);
            this.animFrameId = null;
        }
        this._prev = null;
        console.log('[TrackingEngine] Stopped');
    }

    /**
     * Destroy
     */
    destroy() {
        this.stop();
        this.onFaceUpdate = null;
        this.onNoFace = null;
    }
}