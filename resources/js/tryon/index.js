// resources/js/tryon/index.js

import VirtualTryOn from './VirtualTryOn.js';

// Wait for Alpine to be available (it's loaded by layouts/app.blade.php)
document.addEventListener('alpine:init', () => {
    window.Alpine.data('virtualTryOn', VirtualTryOn);
    console.log('[TryOn] Module registered ✓');
});