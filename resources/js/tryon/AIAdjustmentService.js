// resources/js/tryon/AIAdjustmentService.js

/**
 * Parses natural language prompts and returns adjustment deltas
 * for cap position, size, rotation.
 *
 * No external API needed — runs entirely client-side.
 */
export default class AIAdjustmentService {
    constructor() {
        this.busy = false;
    }

    /**
     * Parse a text prompt into adjustments
     * @param {string} prompt
     * @param {Object} currentState - { capX, capY, capWidth, capScale, capRotation, capOpacity }
     * @returns {Object} { capX, capY, capWidth, capScale, capRotation, capOpacity, message }
     */
    parse(prompt, currentState) {
        const text = prompt.toLowerCase().trim();
        const result = { ...currentState };
        let message = '';

        // === DIRECTIONAL MOVEMENT ===
        if (this._match(text, ['move up', 'go up', 'higher', 'raise', 'lift'])) {
            const amount = this._extractAmount(text, 3);
            result.capY = Math.max(0, result.capY - amount);
            message = `Moved cap up by ${amount}%`;
        }
        else if (this._match(text, ['move down', 'go down', 'lower', 'drop'])) {
            const amount = this._extractAmount(text, 3);
            result.capY = Math.min(80, result.capY + amount);
            message = `Moved cap down by ${amount}%`;
        }
        else if (this._match(text, ['move left', 'go left', 'shift left'])) {
            const amount = this._extractAmount(text, 3);
            result.capX = Math.max(5, result.capX - amount);
            message = `Moved cap left by ${amount}%`;
        }
        else if (this._match(text, ['move right', 'go right', 'shift right'])) {
            const amount = this._extractAmount(text, 3);
            result.capX = Math.min(95, result.capX + amount);
            message = `Moved cap right by ${amount}%`;
        }

        // === SIZE ===
        else if (this._match(text, ['bigger', 'larger', 'enlarge', 'scale up', 'size up', 'increase size'])) {
            const factor = this._extractAmount(text, 15);
            result.capWidth = Math.min(500, result.capWidth + factor);
            result.capScale = Math.min(1.5, result.capScale + 0.1);
            message = `Made cap bigger`;
        }
        else if (this._match(text, ['smaller', 'shrink', 'reduce', 'scale down', 'size down', 'decrease size'])) {
            const factor = this._extractAmount(text, 15);
            result.capWidth = Math.max(60, result.capWidth - factor);
            result.capScale = Math.max(0.5, result.capScale - 0.1);
            message = `Made cap smaller`;
        }

        // === ROTATION ===
        else if (this._match(text, ['tilt left', 'rotate left', 'lean left', 'turn left'])) {
            const deg = this._extractAmount(text, 5);
            result.capRotation = Math.max(-45, result.capRotation - deg);
            message = `Tilted cap left ${deg}°`;
        }
        else if (this._match(text, ['tilt right', 'rotate right', 'lean right', 'turn right'])) {
            const deg = this._extractAmount(text, 5);
            result.capRotation = Math.min(45, result.capRotation + deg);
            message = `Tilted cap right ${deg}°`;
        }
        else if (this._match(text, ['straighten', 'no tilt', 'no rotation', 'level'])) {
            result.capRotation = 0;
            message = `Straightened cap`;
        }

        // === OPACITY ===
        else if (this._match(text, ['transparent', 'fade', 'see through', 'ghost'])) {
            result.capOpacity = Math.max(0.2, result.capOpacity - 0.2);
            message = `Made cap more transparent`;
        }
        else if (this._match(text, ['opaque', 'solid', 'visible', 'full opacity'])) {
            result.capOpacity = 1;
            message = `Set cap to full opacity`;
        }

        // === CENTER ===
        else if (this._match(text, ['center', 'centre', 'middle'])) {
            result.capX = 50;
            message = `Centered cap horizontally`;
        }

        // === RESET ===
        else if (this._match(text, ['reset', 'default', 'start over', 'original'])) {
            // Caller should handle reset — we signal it
            result._reset = true;
            message = `Reset to defaults`;
        }

        // === FIX / AUTO ===
        else if (this._match(text, ['fix', 'auto', 'fit', 'adjust', 'correct', 'align'])) {
            result._autoFit = true;
            message = `Running auto-fit...`;
        }

        // === UNKNOWN ===
        else {
            message = `I didn't understand "${prompt}". Try: move up, bigger, tilt left, center, reset`;
        }

        result.message = message;
        return result;
    }

    /**
     * Check if text contains any of the keywords
     */
    _match(text, keywords) {
        return keywords.some(kw => text.includes(kw));
    }

    /**
     * Extract a numeric amount from text, fallback to default
     */
    _extractAmount(text, defaultVal) {
        const match = text.match(/(\d+)/);
        return match ? parseInt(match[1], 10) : defaultVal;
    }
}