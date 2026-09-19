// resources/js/tryon/ImageProcessor.js

export default class ImageProcessor {
    constructor() {
        this.image = null;        // HTMLImageElement
        this.dataUrl = null;      // Original data URL
        this.panX = 0;           // Pan offset in pixels
        this.panY = 0;
        this.scale = 1;
        this.dragging = false;
        this.dragStartX = 0;
        this.dragStartY = 0;
        this.panStartX = 0;
        this.panStartY = 0;
    }

    /**
     * Load image from File input
     * @param {File} file
     * @returns {Promise<string>} data URL
     */
    loadFile(file) {
        return new Promise((resolve, reject) => {
            if (!file || !file.type.startsWith('image/')) {
                reject(new Error('Invalid file type'));
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const dataUrl = e.target.result;
                this.dataUrl = dataUrl;

                // Create an image element for detection
                const img = new Image();
                img.onload = () => {
                    this.image = img;
                    this.resetTransform();
                    console.log('[ImageProcessor] Loaded:',
                        `${img.naturalWidth}x${img.naturalHeight}`);
                    resolve(dataUrl);
                };
                img.onerror = () => reject(new Error('Image load failed'));
                img.src = dataUrl;
            };
            reader.onerror = () => reject(new Error('File read failed'));
            reader.readAsDataURL(file);
        });
    }

    /**
     * Reset pan and zoom
     */
    resetTransform() {
        this.panX = 0;
        this.panY = 0;
        this.scale = 1;
        this.dragging = false;
    }

    /**
     * Zoom by multiplier
     * @param {number} factor - e.g. 1.25 for zoom in, 0.8 for zoom out
     */
    zoom(factor) {
        this.scale = Math.max(0.3, Math.min(4, this.scale * factor));
    }

    /**
     * Start drag
     */
    startDrag(clientX, clientY) {
        this.dragging = true;
        this.dragStartX = clientX;
        this.dragStartY = clientY;
        this.panStartX = this.panX;
        this.panStartY = this.panY;
    }

    /**
     * During drag
     */
    onDrag(clientX, clientY) {
        if (!this.dragging) return;
        this.panX = this.panStartX + (clientX - this.dragStartX);
        this.panY = this.panStartY + (clientY - this.dragStartY);
    }

    /**
     * End drag
     */
    endDrag() {
        this.dragging = false;
    }

    /**
     * Draw the image onto a canvas with current transform
     * Used for creating the final composite
     * @param {CanvasRenderingContext2D} ctx
     * @param {number} viewW - viewport width
     * @param {number} viewH - viewport height
     */
    drawToCanvas(ctx, viewW, viewH) {
        if (!this.image) return;

        ctx.save();
        ctx.translate(viewW / 2 + this.panX, viewH / 2 + this.panY);
        ctx.scale(this.scale, this.scale);

        // Cover-fit the image
        const imgAspect = this.image.naturalWidth / this.image.naturalHeight;
        const viewAspect = viewW / viewH;

        let drawW, drawH;
        if (imgAspect > viewAspect) {
            drawH = viewH;
            drawW = viewH * imgAspect;
        } else {
            drawW = viewW;
            drawH = viewW / imgAspect;
        }

        ctx.drawImage(this.image, -drawW / 2, -drawH / 2, drawW, drawH);
        ctx.restore();
    }

    /**
     * Create a canvas with the image drawn at current transform
     * For face detection on uploaded images
     */
    createDetectionCanvas(viewW, viewH) {
        const canvas = document.createElement('canvas');
        canvas.width = viewW;
        canvas.height = viewH;
        const ctx = canvas.getContext('2d');
        this.drawToCanvas(ctx, viewW, viewH);
        return canvas;
    }
}