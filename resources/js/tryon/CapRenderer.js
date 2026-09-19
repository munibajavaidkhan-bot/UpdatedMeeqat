// resources/js/tryon/CapRenderer.js

import { getCapConfig } from './capConfigs.js';

export default class CapRenderer {
    constructor() {
        this.capImages = {};
        this._loadPromises = {};
    }

    preload(id, src) {
        if (this.capImages[id]) return Promise.resolve(this.capImages[id]);
        if (this._loadPromises[id]) return this._loadPromises[id];

        this._loadPromises[id] = new Promise((resolve, reject) => {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                this.capImages[id] = img;
                console.log(`[CapRenderer] Preloaded: ${id}`);
                resolve(img);
            };
            img.onerror = () => {
                console.error(`[CapRenderer] Failed to load: ${src}`);
                reject(new Error(`Cap image load failed: ${id}`));
            };
            img.src = src;
        });

        return this._loadPromises[id];
    }

    async preloadAll(caps) {
        const promises = caps.map(cap => this.preload(cap.id, cap.overlay));
        await Promise.allSettled(promises);
    }

    /**
     * Calculate cap placement so the cap sits ON the head naturally.
     *
     * Strategy:
     *   1. Cap width = head width * config.widthRatio
     *   2. Cap height derived from cap image aspect ratio
     *   3. Vertical position: cap's BOTTOM edge sits at forehead line
     *      (with small overlap/gap tuned per cap style via config.sitY)
     */
    calculatePlacement(faceData, capId, viewW, viewH, isMirrored = false) {
    if (!faceData || !faceData.landmarks || faceData.landmarks.length === 0) {
        return null;
    }

    const landmarks = faceData.landmarks[0]; // First detected face

    // 1. Get Key Landmarks
    // MediaPipe FaceMesh Indices:
    // 10 = Top of forehead
    // 152 = Bottom of chin
    // 234 = Left cheek / ear boundary
    // 454 = Right cheek / ear boundary
    // 33 = Left eye outer corner, 263 = Right eye outer corner
    
    const forehead = landmarks[10] || landmarks[9];
    const chin = landmarks[152];
    const leftEar = landmarks[234];
    const rightEar = landmarks[454];

    // 2. Calculate Face Dimensions (in Normalized Coordinates 0.0 - 1.0)
    const faceWidthNorm = Math.hypot(
        rightEar.x - leftEar.x,
        rightEar.y - leftEar.y
    );
    const faceHeightNorm = Math.hypot(
        chin.x - forehead.x,
        chin.y - forehead.y
    );

    // 3. Convert Head Position to Viewport Pixels
    let xPixel = forehead.x * viewW;
    const yPixel = forehead.y * viewH;

    if (isMirrored) {
        xPixel = viewW - xPixel;
    }

    // 4. Calculate Cap Width and Height relative to Face Size
    // Cap width should be slightly wider than face width (~1.3x - 1.4x)
    const capWidth = faceWidthNorm * viewW * 1.35;
    
    // Maintain cap image aspect ratio (assuming standard cap ratio ~1:0.75)
    const capAspectRatio = 0.75; 
    const capHeight = capWidth * capAspectRatio;

    // 5. Calculate Y-Offset Shift
    // Shift cap UPWARDS so the bottom rim sits right on the top of the forehead
    // Offset by ~50% to 65% of the cap's height upwards
    const yShift = capHeight * 0.60;
    const finalY = yPixel - yShift;

    // 6. Calculate Head Rotation / Tilt (Roll Angle)
    let angleRad = Math.atan2(
        rightEar.y - leftEar.y,
        rightEar.x - leftEar.x
    );
    if (isMirrored) {
        angleRad = -angleRad;
    }
    const rotationDeg = angleRad * (180 / Math.PI);

    return {
        x: xPixel,                     // X Center Position (px)
        y: finalY,                     // Y Center Position (px)
        width: capWidth,               // Width in px
        height: capHeight,             // Height in px
        rotation: rotationDeg,         // Tilt angle in degrees
        xPercent: (xPixel / viewW) * 100,
        yPercent: (finalY / viewH) * 100
    };
}

    drawCap(ctx, capId, placement, scale = 1, opacity = 1) {
        const img = this.capImages[capId];
        if (!img || !placement) return;

        ctx.save();
        ctx.globalAlpha = opacity;
        ctx.translate(placement.x, placement.y);
        if (placement.rotation) {
            ctx.rotate((placement.rotation * Math.PI) / 180);
        }
        ctx.scale(scale, scale);

        const w = placement.width;
        const h = placement.height || (w * (img.naturalHeight / img.naturalWidth));

        ctx.drawImage(img, -w / 2, -h / 2, w, h);
        ctx.restore();
    }
}