<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IhramGuide;

class IhramGuideSeeder extends Seeder {
    public function run(): void {
        $guides = [

            // ========== GENERAL ==========
            [
                'category'   => 'general',
                'title_en'   => 'What is Ihram?',
                'title_ur'   => 'احرام کیا ہے؟',
                'content_en' => 'Ihram is the sacred state a Muslim must enter before performing Hajj or Umrah. It involves wearing specific garments and having the intention (Niyat) to perform the pilgrimage.',
                'content_ur' => 'احرام وہ مقدس حالت ہے جس میں مسلمان کو حج یا عمرہ سے پہلے داخل ہونا ضروری ہے۔',
                'image'       => 'images/ihram-guides/01-what-is-ihram.svg',
                'icon'        => '🕌',
                'sort_order'  => 1,
            ],
            [
                'category'   => 'general',
                'title_en'   => 'How to Enter Ihram',
                'title_ur'   => 'احرام میں کیسے داخل ہوں',
                'content_en' => '1. Perform Ghusl (bath) or Wudu. 2. Wear Ihram garments. 3. Offer 2 rakaat Nafl prayer. 4. Make Niyat at Meeqat. 5. Recite Talbiyah: Labbayk Allahumma Labbayk.',
                'content_ur' => '۱۔ غسل یا وضو کریں۔ ۲۔ احرام کے کپڑے پہنیں۔ ۳۔ ۲ رکعت نفل پڑھیں۔ ۴۔ میقات پر نیت کریں۔ ۵۔ تلبیہ پڑھیں۔',
                'image'       => 'images/ihram-guides/02-how-to-enter-ihram.svg',
                'icon'        => '📋',
                'sort_order'  => 2,
            ],
            [
                'category'   => 'general',
                'title_en'   => 'Talbiyah — Most Important',
                'title_ur'   => 'تلبیہ — سب سے اہم',
                'content_en' => 'Labbayk Allahumma Labbayk. Labbayk la sharika laka labbayk. Innal hamda wan-ni\'mata laka wal mulk. La sharika lak.',
                'content_ur' => 'لبیک اللہم لبیک، لبیک لا شریک لک لبیک، ان الحمد والنعمۃ لک والملک، لا شریک لک۔',
                'image'       => 'images/ihram-guides/03-talbiyah.svg',
                'icon'        => '🤲',
                'sort_order'  => 3,
            ],

            // ========== MEN ==========
            [
                'category'   => 'men',
                'title_en'   => 'Ihram Garments for Men',
                'title_ur'   => 'مردوں کے احرام کے کپڑے',
                'content_en' => 'Men wear two pieces of unstitched white cloth. Rida (upper body) and Izar (lower body). These should be clean, white, preferably cotton fabric.',
                'content_ur' => 'مرد دو بغیر سلے سفید کپڑے پہنتے ہیں۔ رداء (اوپری جسم) اور ازار (نچلا جسم)۔',
                'image'       => 'images/ihram-guides/04-ihram-garments-men.svg',
                'icon'        => '👘',
                'sort_order'  => 1,
            ],
            [
                'category'   => 'men',
                'title_en'   => 'Footwear for Men',
                'title_ur'   => 'مردوں کے لیے جوتے',
                'content_en' => 'Men must wear sandals (Hawai Chappal) that leave the ankles and back of feet uncovered. Closed-toe shoes are not allowed during Ihram.',
                'content_ur' => 'مردوں کو ایسی چپل پہننی چاہیے جو ٹخنے اور پاؤں کی پشت کو ننگا رکھے۔ بند جوتے ممنوع ہیں۔',
                'image'       => 'images/ihram-guides/05-footwear-men.svg',
                'icon'        => '👡',
                'sort_order'  => 2,
            ],
            [
                'category'   => 'men',
                'title_en'   => 'Head Covering for Men',
                'title_ur'   => 'مردوں کے لیے سر ڈھانپنا',
                'content_en' => 'Men MUST NOT cover their heads during Ihram. Hats, caps, and turbans are strictly prohibited. Umbrella can be used for shade.',
                'content_ur' => 'مردوں کو احرام کے دوران سر نہیں ڈھانپنا چاہیے۔ ٹوپی، کیپ اور پگڑی سختی سے ممنوع ہے۔',
                'image'       => 'images/ihram-guides/06-head-covering-men.svg',
                'icon'        => '🚫',
                'sort_order'  => 3,
            ],
            [
                'category'   => 'men',
                'title_en'   => 'Idtiba — Wearing Rida',
                'title_ur'   => 'اضطباع — رداء پہننا',
                'content_en' => 'During Tawaf, men should wear Rida in Idtiba style — right shoulder uncovered, left shoulder covered. This is Sunnah for Tawaf only.',
                'content_ur' => 'طواف کے دوران، مرد اضطباع کے انداز میں رداء پہنیں — دایاں کندھا ننگا، بایاں ڈھکا ہوا۔',
                'image'       => 'images/ihram-guides/07-idtiba-rida.svg',
                'icon'        => '🔄',
                'sort_order'  => 4,
            ],

            // ========== WOMEN ==========
            [
                'category'   => 'women',
                'title_en'   => 'Ihram Garments for Women',
                'title_ur'   => 'خواتین کے احرام کے کپڑے',
                'content_en' => 'Women can wear any modest, loose-fitting clothes that cover the entire body. White is preferred but not mandatory. Normal Abaya or Salwar Kameez is perfectly fine.',
                'content_ur' => 'خواتین کوئی بھی شائستہ، ڈھیلے ڈھالے کپڑے پہن سکتی ہیں۔ سفید رنگ بہتر ہے لیکن لازمی نہیں۔',
                'image'       => 'images/ihram-guides/08-ihram-garments-women.svg',
                'icon'        => '👒',
                'sort_order'  => 1,
            ],
            [
                'category'   => 'women',
                'title_en'   => 'Face & Hands in Ihram',
                'title_ur'   => 'احرام میں چہرہ اور ہاتھ',
                'content_en' => 'Women must keep face and hands uncovered in Ihram. Wearing Niqab is not allowed. However, if non-Mahram men are present nearby, face can be covered.',
                'content_ur' => 'خواتین کو احرام میں چہرہ اور ہاتھ کھلا رکھنا ضروری ہے۔ نقاب پہننا جائز نہیں۔',
                'image'       => 'images/ihram-guides/09-face-hands-ihram.svg',
                'icon'        => '😊',
                'sort_order'  => 2,
            ],
            [
                'category'   => 'women',
                'title_en'   => 'Women & Head Covering',
                'title_ur'   => 'خواتین اور سر کا ڈھانپنا',
                'content_en' => 'Women MUST keep their heads covered at all times during Ihram. Hijab must always be worn. Only the face (and hands) must remain uncovered.',
                'content_ur' => 'خواتین کو احرام کے دوران ہر وقت سر ڈھانپنا ضروری ہے۔ حجاب ہمیشہ پہنا جائے۔',
                'image'       => 'images/ihram-guides/10-women-head-covering.svg',
                'icon'        => '🧕',
                'sort_order'  => 3,
            ],

            // ========== PROHIBITED ==========
            [
                'category'   => 'prohibited',
                'title_en'   => 'Cutting Hair or Nails',
                'title_ur'   => 'بال یا ناخن کاٹنا',
                'content_en' => 'Strictly prohibited to cut, trim, or shave any hair or nails from any part of the body while in Ihram. This applies to both men and women.',
                'content_ur' => 'احرام میں جسم کے کسی بھی حصے سے بال یا ناخن کاٹنا، تراشنا یا مونڈنا سختی سے ممنوع ہے۔',
                'image'       => 'images/ihram-guides/11-cutting-hair-nails.svg',
                'icon'        => '✂️',
                'sort_order'  => 1,
            ],
            [
                'category'   => 'prohibited',
                'title_en'   => 'Using Perfume or Fragrance',
                'title_ur'   => 'خوشبو استعمال کرنا',
                'content_en' => 'Absolutely no perfume, scented soap, or fragrant oil allowed after entering Ihram. This includes scented deodorants, creams, and lotion with fragrance.',
                'content_ur' => 'احرام باندھنے کے بعد کوئی خوشبو، خوشبودار صابن یا تیل بالکل جائز نہیں۔',
                'image'       => 'images/ihram-guides/12-perfume-fragrance.svg',
                'icon'        => '🚿',
                'sort_order'  => 2,
            ],
            [
                'category'   => 'prohibited',
                'title_en'   => 'Hunting & Killing Animals',
                'title_ur'   => 'شکار اور جانور مارنا',
                'content_en' => 'Hunting any land animal or helping anyone hunt is completely forbidden during Ihram. However, harmful insects like mosquitoes can be killed.',
                'content_ur' => 'احرام کے دوران کسی بھی خشکی کے جانور کا شکار کرنا یا مدد کرنا بالکل ممنوع ہے۔',
                'image'       => 'images/ihram-guides/13-hunting-animals.svg',
                'icon'        => '🦌',
                'sort_order'  => 3,
            ],
            [
                'category'   => 'prohibited',
                'title_en'   => 'Marital Relations',
                'title_ur'   => 'ازدواجی تعلقات',
                'content_en' => 'Marital intimacy is strictly prohibited during Ihram. Even talking about such matters is discouraged. This is one of the most serious violations.',
                'content_ur' => 'احرام کے دوران ازدواجی قربت سختی سے ممنوع ہے۔ یہ سب سے سنگین خلاف ورزیوں میں سے ایک ہے۔',
                'image'       => 'images/ihram-guides/14-marital-relations.svg',
                'icon'        => '💑',
                'sort_order'  => 4,
            ],
            [
                'category'   => 'prohibited',
                'title_en'   => 'Arguments & Fighting',
                'title_ur'   => 'جھگڑا اور لڑائی',
                'content_en' => 'Any arguments, fighting, or use of bad language is strictly prohibited. The Quran says: "No sexual relations, no sinning, and no disputing during Hajj." (2:197)',
                'content_ur' => 'کوئی بھی جھگڑا، لڑائی یا بری زبان سختی سے ممنوع ہے۔ قرآن کہتا ہے: حج میں نہ بے حیائی ہو، نہ گناہ، نہ جھگڑا۔',
                'image'       => 'images/ihram-guides/15-arguments-fighting.svg',
                'icon'        => '🤝',
                'sort_order'  => 5,
            ],
            [
                'category'   => 'prohibited',
                'title_en'   => 'Wearing Stitched Clothes (Men)',
                'title_ur'   => 'سلے کپڑے پہننا (مرد)',
                'content_en' => 'Men are prohibited from wearing any stitched or sewn garments including shirts, pants, underwear, or gloves. Only unstitched cloth is allowed.',
                'content_ur' => 'مردوں کو کوئی بھی سلے ہوئے کپڑے پہننا ممنوع ہے جیسے قمیض، پتلون، انڈرویئر یا دستانے۔',
                'image'       => 'images/ihram-guides/16-stitched-clothes-men.svg',
                'icon'        => '👔',
                'sort_order'  => 6,
            ],

            // ========== RECOMMENDED ==========
            [
                'category'   => 'recommended',
                'title_en'   => 'Recite Talbiyah Frequently',
                'title_ur'   => 'کثرت سے تلبیہ پڑھیں',
                'content_en' => 'It is highly recommended to recite Talbiyah as much as possible — when standing, sitting, walking, and especially when the atmosphere changes.',
                'content_ur' => 'حالت احرام میں زیادہ سے زیادہ تلبیہ پڑھنا بہت مستحب ہے۔',
                'image'       => 'images/ihram-guides/17-recite-talbiyah.svg',
                'icon'        => '📿',
                'sort_order'  => 1,
            ],
            [
                'category'   => 'recommended',
                'title_en'   => 'Lots of Dhikr & Dua',
                'title_ur'   => 'کثرت سے ذکر اور دعا',
                'content_en' => 'Engage in constant remembrance of Allah, recite Quran, and make lots of dua. These sacred moments in Ihram are especially blessed for acceptance of prayers.',
                'content_ur' => 'اللہ کا کثرت سے ذکر کریں، قرآن پڑھیں، اور خوب دعائیں کریں۔ یہ لمحات دعا کی قبولیت کے لیے خاص ہیں۔',
                'image'       => 'images/ihram-guides/18-dhikr-dua.svg',
                'icon'        => '✨',
                'sort_order'  => 2,
            ],
            [
                'category'   => 'recommended',
                'title_en'   => 'Patience & Good Manners',
                'title_ur'   => 'صبر اور اچھے اخلاق',
                'content_en' => 'Show patience, kindness, and respect to fellow pilgrims. Help the elderly and weak. Smile and greet others with Salam.',
                'content_ur' => 'ہم حجاج کے ساتھ صبر، مہربانی اور احترام کا مظاہرہ کریں۔ بوڑھوں اور کمزوروں کی مدد کریں۔',
                'image'       => 'images/ihram-guides/19-patience-manners.svg',
                'icon'        => '😊',
                'sort_order'  => 3,
            ],
        ];

        foreach ($guides as $guide) {
            IhramGuide::create($guide);
        }

        $this->command->info('✅ Ihram Guides seeded! (' . count($guides) . ' guides)');
    }
}