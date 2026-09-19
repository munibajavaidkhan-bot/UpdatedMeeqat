// resources/js/tryon/CameraController.js

export default class CameraController {
    constructor() {
        this.stream = null;
        this.videoElement = null;
        this.cameras = [];
        this.currentCameraIndex = 0;
        this.active = false;
    }

    /**
     * Enumerate available video input devices
     */
    async enumerateCameras() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            this.cameras = devices.filter(d => d.kind === 'videoinput');
            return this.cameras;
        } catch (e) {
            console.warn('[Camera] Cannot enumerate devices:', e);
            this.cameras = [];
            return [];
        }
    }

    /**
     * Start camera stream
     * @param {HTMLVideoElement} videoEl
     * @param {number} cameraIndex - index in this.cameras array
     */
    async start(videoEl, cameraIndex = 0) {
        this.videoElement = videoEl;
        this.currentCameraIndex = cameraIndex;

        // Stop any existing stream
        this.stop();

        const constraints = {
            video: {
                width: { ideal: 1280 },
                height: { ideal: 720 },
                facingMode: 'user',
            },
            audio: false,
        };

        // If we have a specific device ID, use it
        if (this.cameras.length > 0 && this.cameras[cameraIndex]) {
            constraints.video = {
                deviceId: { exact: this.cameras[cameraIndex].deviceId },
                width: { ideal: 1280 },
                height: { ideal: 720 },
            };
        }

        try {
            this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            this.videoElement.srcObject = this.stream;

            // Wait for video to be ready
            await new Promise((resolve, reject) => {
                this.videoElement.onloadedmetadata = () => {
                    this.videoElement.play()
                        .then(resolve)
                        .catch(reject);
                };
                // Timeout after 5s
                setTimeout(() => reject(new Error('Video load timeout')), 5000);
            });

            this.active = true;

            // Re-enumerate to get labels (after permission granted)
            await this.enumerateCameras();

            console.log('[Camera] Started ✓',
                `${this.videoElement.videoWidth}x${this.videoElement.videoHeight}`);

            return true;
        } catch (err) {
            console.error('[Camera] Start failed:', err);
            this.active = false;
            throw err;
        }
    }

    /**
     * Stop camera
     */
    stop() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
        if (this.videoElement) {
            this.videoElement.srcObject = null;
        }
        this.active = false;
        console.log('[Camera] Stopped');
    }

    /**
     * Switch to next camera
     */
    async switchCamera(videoEl) {
        if (this.cameras.length < 2) return false;

        this.currentCameraIndex = (this.currentCameraIndex + 1) % this.cameras.length;
        await this.start(videoEl, this.currentCameraIndex);
        return true;
    }

    /**
     * Capture current video frame to a canvas
     * @returns {HTMLCanvasElement}
     */
    captureFrame() {
        if (!this.videoElement || !this.active) return null;

        const canvas = document.createElement('canvas');
        canvas.width = this.videoElement.videoWidth;
        canvas.height = this.videoElement.videoHeight;
        const ctx = canvas.getContext('2d');

        // Mirror horizontally (front camera)
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(this.videoElement, 0, 0);
        ctx.setTransform(1, 0, 0, 1, 0, 0); // Reset transform

        return canvas;
    }

    /**
     * Destroy
     */
    destroy() {
        this.stop();
        this.videoElement = null;
        this.cameras = [];
    }
}