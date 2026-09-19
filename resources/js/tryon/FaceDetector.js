// resources/js/tryon/FaceDetector.js

import { FilesetResolver, FaceLandmarker } from '@mediapipe/tasks-vision';

const LANDMARK = {
    CROWN: 10,
    CHIN: 152,
    LEFT_EAR: 234,
    RIGHT_EAR: 454,
    LEFT_FOREHEAD: 109,
    RIGHT_FOREHEAD: 338,
    NOSE_TIP: 1,
    LEFT_EYE_OUTER: 33,
    RIGHT_EYE_OUTER: 263,
};

export default class FaceDetector {
    constructor() {
        this.videoLandmarker = null;
        this.imageLandmarker = null;
        this.vision = null;
        this.ready = false;
        this._initPromise = null;
    }

    async init() {
        if (this._initPromise) return this._initPromise;
        this._initPromise = this._doInit();
        return this._initPromise;
    }

    async _doInit() {
        try {
            console.log('[FaceDetector] Initializing MediaPipe...');

            this.vision = await FilesetResolver.forVisionTasks(
                'https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@latest/wasm'
            );

            // Create VIDEO landmarker
            this.videoLandmarker = await FaceLandmarker.createFromOptions(this.vision, {
                baseOptions: {
                    modelAssetPath: '/models/face_landmarker.task',
                    delegate: 'GPU',
                },
                runningMode: 'VIDEO',
                numFaces: 1,
                minFaceDetectionConfidence: 0.5,
                minFacePresenceConfidence: 0.5,
                minTrackingConfidence: 0.5,
            });

            this.ready = true;
            console.log('[FaceDetector] Video landmarker ready ✓');
            return true;
        } catch (err) {
            console.error('[FaceDetector] Init failed:', err);
            this.ready = false;
            throw err;
        }
    }

    /**
     * Lazily create IMAGE landmarker (separate instance)
     */
    async _getImageLandmarker() {
        if (this.imageLandmarker) return this.imageLandmarker;

        console.log('[FaceDetector] Creating image landmarker...');
        this.imageLandmarker = await FaceLandmarker.createFromOptions(this.vision, {
            baseOptions: {
                modelAssetPath: '/models/face_landmarker.task',
                delegate: 'GPU',
            },
            runningMode: 'IMAGE',
            numFaces: 1,
            minFaceDetectionConfidence: 0.5,
            minFacePresenceConfidence: 0.5,
            minTrackingConfidence: 0.5,
        });
        console.log('[FaceDetector] Image landmarker ready ✓');
        return this.imageLandmarker;
    }

    /**
     * Detect on video frame
     */
    detectVideo(video, timestamp) {
        if (!this.ready || !this.videoLandmarker) return null;

        try {
            const result = this.videoLandmarker.detectForVideo(video, timestamp);
            return this._parseResult(result, video.videoWidth, video.videoHeight);
        } catch (e) {
            return null;
        }
    }

    /**
     * Detect on static image (uses separate landmarker instance)
     */
    async detectImage(image) {
        if (!this.ready) return null;

        try {
            const landmarker = await this._getImageLandmarker();
            const result = landmarker.detect(image);
            const w = image.naturalWidth || image.width;
            const h = image.naturalHeight || image.height;
            return this._parseResult(result, w, h);
        } catch (e) {
            console.error('[FaceDetector] Image detection error:', e);
            return null;
        }
    }

    _parseResult(result, frameW, frameH) {
        if (!result || !result.faceLandmarks || result.faceLandmarks.length === 0) {
            return null;
        }

        const lm = result.faceLandmarks[0];

        const crown     = lm[LANDMARK.CROWN];
        const chin      = lm[LANDMARK.CHIN];
        const leftEar   = lm[LANDMARK.LEFT_EAR];
        const rightEar  = lm[LANDMARK.RIGHT_EAR];
        const leftFH    = lm[LANDMARK.LEFT_FOREHEAD];
        const rightFH   = lm[LANDMARK.RIGHT_FOREHEAD];
        const noseTip   = lm[LANDMARK.NOSE_TIP];
        const leftEye   = lm[LANDMARK.LEFT_EYE_OUTER];
        const rightEye  = lm[LANDMARK.RIGHT_EYE_OUTER];

        const headWidth = Math.abs(rightEar.x - leftEar.x);
        const headHeight = Math.abs(chin.y - crown.y);

        const foreheadCenterX = (leftFH.x + rightFH.x) / 2;
        const foreheadCenterY = (leftFH.y + rightFH.y) / 2;

        const headCenterX = (leftEar.x + rightEar.x) / 2;
        const headCenterY = (crown.y + chin.y) / 2;

        const deltaEyeX = rightEye.x - leftEye.x;
        const deltaEyeY = rightEye.y - leftEye.y;
        const rollRad = Math.atan2(deltaEyeY, deltaEyeX);
        const rollDeg = rollRad * (180 / Math.PI);

        const noseToLeftEar = Math.abs(noseTip.x - leftEar.x);
        const noseToRightEar = Math.abs(noseTip.x - rightEar.x);
        const yawRatio = noseToLeftEar / (noseToLeftEar + noseToRightEar);

        return {
            headWidth,
            headHeight,
            foreheadCenter: { x: foreheadCenterX, y: foreheadCenterY },
            crown: { x: crown.x, y: crown.y },
            headCenter: { x: headCenterX, y: headCenterY },
            chin: { x: chin.x, y: chin.y },
            leftEar: { x: leftEar.x, y: leftEar.y },
            rightEar: { x: rightEar.x, y: rightEar.y },
            rollDeg,
            yawRatio,
            frameW,
            frameH,
            confidence: 1.0,
            landmarks: lm,
        };
    }

    destroy() {
        if (this.videoLandmarker) {
            this.videoLandmarker.close();
            this.videoLandmarker = null;
        }
        if (this.imageLandmarker) {
            this.imageLandmarker.close();
            this.imageLandmarker = null;
        }
        this.ready = false;
        this._initPromise = null;
    }
}