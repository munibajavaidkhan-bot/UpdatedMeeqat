// resources/js/tryon/capConfigs.js

const ASSETS = window.CAP_ASSETS || {
    kufi:    '/images/caps/Kufi-removebg-preview.png',
    taqiyah: '/images/caps/taqiyah-removebg-preview.png',
    amama:   '/images/caps/Amama-removebg-preview.png',
};

export const CAP_CONFIGS = [
    {
        id: 'kufi',
        name: 'Kufi Cap',
        desc: 'Traditional rounded prayer cap',
        overlay: ASSETS.kufi,
        widthRatio: 1.15,   // Cap slightly wider than head width
        sitY: 0.12,         // Cap bottom sits 12% of head-height below forehead
        heightRatio: 0.55,
        defaultW: 220,
        defaultS: 1,
        defaultY: 22,
    },
    {
        id: 'taqiyah',
        name: 'Taqiyah',
        desc: 'Lightweight skull cap',
        overlay: ASSETS.taqiyah,
        widthRatio: 1.10,
        sitY: 0.15,         // Sits lower (skull-hugging)
        heightRatio: 0.50,
        defaultW: 210,
        defaultS: 1,
        defaultY: 24,
    },
    {
        id: 'amama',
        name: 'Amama / Turban',
        desc: 'Full turban wrap style',
        overlay: ASSETS.amama,
        widthRatio: 1.40,   // Wider — turban is bulky
        sitY: 0.08,         // Sits higher (bulky top)
        heightRatio: 0.75,
        defaultW: 280,
        defaultS: 1,
        defaultY: 20,
    },
];

export function getCapConfig(id) {
    return CAP_CONFIGS.find(c => c.id === id) || CAP_CONFIGS[0];
}