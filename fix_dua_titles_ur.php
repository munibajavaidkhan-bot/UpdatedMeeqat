<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$titles = [
    'Dua when starting Tawaf' => 'طواف شروع کرنے کی دعا',
    'Dua between Yemeni Corner and Black Stone' => 'یمنی کونے اور کعبے کے پتھر کے درمیان دعا',
    'Dua during Tawaf (General)' => 'طواف کے دوران عام دعا',
    'Dua at Safa and Marwah' => 'صفا و مروہ پر دعا',
    'Supplication on Safa and Marwah' => 'صفا و مروہ کی دعا',
    'Dua after completing Saee' => 'سعی مکمل کرنے کے بعد کی دعا',
    'Dua at Multazam (between door and Black Stone)' => 'ملتزم پر دعا',
    'Dua before drinking Zamzam' => 'زمزم پینے سے پہلے کی دعا',
    'Dua when touching Black Stone' => 'کعبے کے پتھر کو چھونے کی دعا',
    'Talbiyah for Hajj' => 'حج کی تلبیہ',
    'Talbiyah for Umrah' => 'عمرہ کی تلبیہ',
    'Dua for entering Masjid al-Haram' => 'مسجد الحرام میں داخل ہونے کی دعا',
    'Dua for leaving Masjid al-Haram' => 'مسجد الحرام سے نکلنے کی دعا',
    'Istikharah Dua' => 'استخارہ کی دعا',
    'Dua for Parents' => 'والدین کے لیے دعا',
    'Dua for Protection' => 'حفاظت کی دعا',
    'Dua for Guidance' => 'ہدایت کی دعا',
    'Dua in Sujood (Prostration)' => 'سجدے میں دعا',
    'Dua when wearing Ihram' => 'احرام پہننے کی دعا',
    'Dua at Arafat' => 'عرفة کی دعا',
    'Dua at Muzdalifah' => 'مزدلفہ کی دعا',
    'Dua at Jamarat' => 'جمرات کی دعا',
    'Dua for sacrifice (Eid)' => 'قربانی کی دعا',
    'Dua for shaving head' => 'سر مونڈنے کی دعا',
    'Dua for entering Mina' => 'منی میں داخل ہونے کی دعا',
    'Dua when leaving Mina' => 'منی سے نکلنے کی دعا',
    'Dua before sleeping' => 'سونے سے پہلے کی دعا',
    'Dua after waking up' => 'جاگنے کے بعد کی دعا',
    'Dua for traveling' => 'سفر کی دعا',
    'Dua when entering mosque' => 'مسجد میں داخل ہونے کی دعا',
    'Dua when leaving mosque' => 'مسجد سے نکلنے کی دعا',
    'Dua before eating' => 'کھانے سے پہلے کی دعا',
    'Dua after eating' => 'کھانے کے بعد کی دعا',
    'Dua for rain (Istisqa)' => 'بارش کی دعا',
    'Dua for distress' => 'مشکل کی دعا',
    'Dua for forgiveness' => 'استغفار کی دعا',
    'Dua for health' => 'صحت کی دعا',
    'Dua for wealth' => 'روزی کی دعا',
    'Dua when looking in mirror' => 'آئینے میکھ دیکھنے کی دعا',
    'Dua when entering home' => 'گھر میں داخل ہونے کی دعا',
    'Dua when leaving home' => 'گھر سے نکلنے کی دعا',
    'Ayatul Kursi' => 'آیت الکرسی',
    'Surah Al-Fatiha' => 'سورۃالفاتحہ',
    'Surah Al-Ikhlas' => 'سورۃالإخلاص',
    'Surah Al-Falaq' => 'سورۃالفلق',
    'Surah An-Nas' => 'سورۃالناس',
    'Dua Qunut' => 'دعائے قنوت',
    'Dua for the deceased' => 'مرحوم کے لیے دжа',
    'Dua for marriage' => 'شادی کی دعا',
    'Dua for seeking knowledge' => 'علم حاصل کرنے کی دعا',
    'Dua when it rains' => 'بارش ہونے پر کی دعا',
    'Dua after sneezing' => 'چھینک آنے کے بعد کی دعا',
];

$updated = 0;
foreach ($titles as $en => $ur) {
    $affected = DB::table('duas')->where('title_en', $en)->update(['title_ur' => $ur]);
    if ($affected) {
        $updated++;
        echo "OK: {$en} => {$ur}\n";
    }
}

// For any remaining duas without urdu title, set a generic one
$remaining = DB::table('duas')->whereNull('title_ur')->get();
foreach ($remaining as $dua) {
    DB::table('duas')->where('id', $dua->id)->update(['title_ur' => $dua->title_en]);
    echo "Fallback: {$dua->title_en}\n";
    $updated++;
}

echo "\nDone! Updated {$updated} duas with Urdu titles.\n";
