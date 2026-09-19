<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Dua;
use App\Models\Niyat;

class DuaNiyatSeeder extends Seeder {
    public function run(): void {
        // =============================================
        // CATEGORIES
        // =============================================
        $categories = [
            ['name_en' => 'Tawaf',                'name_ar' => 'طواف',               'slug' => 'tawaf',          'icon' => '🕋'],
            ['name_en' => 'Safa & Marwah',        'name_ar' => 'الصفا والمروة',      'slug' => 'safa-marwah',    'icon' => '⛰️'],
            ['name_en' => 'Hajj',                 'name_ar' => 'الحج',               'slug' => 'hajj',           'icon' => '🕋'],
            ['name_en' => 'Umrah',                'name_ar' => 'العمرة',             'slug' => 'umrah',          'icon' => '🕋'],
            ['name_en' => 'Arafat',               'name_ar' => 'عرفة',               'slug' => 'arafat',         'icon' => '⛰️'],
            ['name_en' => 'Muzdalifah & Mina',    'name_ar' => 'مزدلفة ومنى',        'slug' => 'muzdalifah-mina','icon' => '🌙'],
            ['name_en' => 'General Supplications','name_ar' => 'أدعية عامة',         'slug' => 'general',        'icon' => '🤲'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->command->info('✅ Categories created!');

        // =============================================
        // DUAS
        // =============================================
        $duas = [
            // --- TAWAF (category_id: 1) ---
            [
                'category_id'   => 1,
                'title_en'      => 'Dua when starting Tawaf',
                'arabic_text'   => 'بِسْمِ اللَّهِ وَاللَّهُ أَكْبَرُ، اللَّهُمَّ إِيمَانًا بِكَ وَتَصْدِيقًا بِكِتَابِكَ وَوَفَاءً بِعَهْدِكَ وَاتِّبَاعًا لِسُنَّةِ نَبِيِّكَ مُحَمَّدٍ ﷺ',
                'transliteration' => 'Bismillahi wallahu akbar. Allahumma imanan bika wa tasdiqan bikitabika wa wafaan bi\'ahdika wattiba\'an lisunnati nabiyyika Muhammadin sallallahu alayhi wa sallam.',
                'translation_en' => 'In the name of Allah, Allah is the Greatest. O Allah, out of faith in You, believing in Your Book, fulfilling Your covenant, and following the Sunnah of Your Prophet Muhammad ﷺ.',
                'translation_ur' => 'اللہ کے نام سے، اللہ سب سے بڑا ہے۔ اے اللہ! تجھ پر ایمان لاتے ہوئے، تیری کتاب کی تصدیق کرتے ہوئے، تیرے عہد کو پورا کرتے ہوئے اور تیرے نبی محمد ﷺ کی سنت کی پیروی کرتے ہوئے۔',
                'reference'     => 'Sahih al-Bukhari (practice of the Prophet)',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 1,
                'title_en'      => 'Dua between Yemeni Corner and Black Stone',
                'arabic_text'   => 'رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ',
                'transliteration' => 'Rabbana atina fid-dunya hasanatan wa fil-akhirati hasanatan waqina adhaban-nar.',
                'translation_en' => 'Our Lord, give us in this world good and in the Hereafter good and protect us from the punishment of the Fire.',
                'translation_ur' => 'اے ہمارے رب! ہمیں دنیا میں بھی بھلائی دے اور آخرت میں بھی بھلائی دے اور ہمیں دوزخ کے عذاب سے بچا۔',
                'reference'     => 'Surah Al-Baqarah 2:201',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 1,
                'title_en'      => 'Dua during Tawaf (General)',
                'arabic_text'   => 'لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ، وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ',
                'transliteration' => 'La ilaha illallah wahdahu la sharika lah, lahul mulku wa lahul hamdu, wa huwa ala kulli shay-in qadir.',
                'translation_en' => 'There is no god but Allah alone, with no partner. His is the dominion, His is the praise, and He is over all things competent.',
                'translation_ur' => 'اللہ کے سوا کوئی معبود نہیں، وہ اکیلا ہے، اس کا کوئی شریک نہیں۔ اسی کے لیے بادشاہت ہے اور اسی کے لیے تمام تعریفیں ہیں، اور وہ ہر چیز پر قادر ہے۔',
                'reference'     => 'Sahih Muslim',
                'is_featured'   => true,
            ],

            // --- SAFA & MARWAH (category_id: 2) ---
            [
                'category_id'   => 2,
                'title_en'      => 'Dua at Safa and Marwah',
                'arabic_text'   => 'إِنَّ الصَّفَا وَالْمَرْوَةَ مِن شَعَائِرِ اللَّهِ، فَمَنْ حَجَّ الْبَيْتَ أَوِ اعْتَمَرَ فَلَا جُنَاحَ عَلَيْهِ أَن يَطَّوَّفَ بِهِمَا',
                'transliteration' => 'Innas-safa wal marwata min sha\'a\'irillah, faman hajjal bayta awi\'tamara fala junaha alayhi an yattawwafa bihima.',
                'translation_en' => 'Indeed, Safa and Marwah are among the symbols of Allah. So whoever makes Hajj to the House or performs Umrah, there is no blame upon him to walk between them.',
                'translation_ur' => 'بے شک صفا اور مروہ اللہ کی نشانیوں میں سے ہیں۔ پس جو شخص بیت اللہ کا حج یا عمرہ کرے تو اس پر ان کے درمیان چلنے میں کوئی گناہ نہیں۔',
                'reference'     => 'Surah Al-Baqarah 2:158',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 2,
                'title_en'      => 'Supplication on Safa and Marwah',
                'arabic_text'   => 'اللَّهُمَّ إِنَّكَ قُلْتَ ادْعُونِي أَسْتَجِبْ لَكُمْ، وَإِنَّكَ لَا تُخْلِفُ الْمِيعَادَ، رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ',
                'transliteration' => 'Allahumma innaka qulta ud\'uni astajib lakum, wa innaka la tukhliful mi\'ad. Rabbana atina fid-dunya hasanatan wa fil-akhirati hasanatan waqina adhaban-nar.',
                'translation_en' => 'O Allah, You said: Call upon Me, I will respond to you. And You never break Your promise. Our Lord, give us good in this world and good in the Hereafter and protect us from the punishment of the Fire.',
                'translation_ur' => 'اے اللہ! تو نے فرمایا ہے کہ مجھ سے دعا کرو، میں تمہاری دعا قبول کروں گا۔ اور بے شک تو وعدہ خلافی نہیں کرتا۔ اے ہمارے رب! ہمیں دنیا میں بھلائی دے اور آخرت میں بھلائی دے اور ہمیں دوزخ کے عذاب سے بچا۔',
                'reference'     => 'Quran 40:60 & 2:201',
                'is_featured'   => true,
            ],

            // --- HAJJ (category_id: 3) ---
            [
                'category_id'   => 3,
                'title_en'      => 'Talbiyah for Hajj',
                'arabic_text'   => 'لَبَّيْكَ اللَّهُمَّ لَبَّيْكَ، لَبَّيْكَ لَا شَرِيكَ لَكَ لَبَّيْكَ، إِنَّ الْحَمْدَ وَالنِّعْمَةَ لَكَ وَالْمُلْكُ، لَا شَرِيكَ لَكَ',
                'transliteration' => 'Labbaik Allahumma labbaik, labbaik la sharika laka labbaik, innal hamda wan\'nimata laka wal mulk, la sharika lak.',
                'translation_en' => 'Here I am, O Allah, here I am. Here I am, You have no partner, here I am. Verily all praise, blessings and sovereignty belong to You. You have no partner.',
                'translation_ur' => 'میں حاضر ہوں اے اللہ! میں حاضر ہوں۔ میں حاضر ہوں، تیرا کوئی شریک نہیں، میں حاضر ہوں۔ بے شک تمام تعریفیں اور نعمتیں تیری ہی ہیں اور بادشاہت بھی تیری ہی ہے، تیرا کوئی شریک نہیں۔',
                'reference'     => 'Sahih al-Bukhari & Muslim',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 3,
                'title_en'      => 'Dua for entering Makkah',
                'arabic_text'   => 'اللَّهُمَّ إِنَّ هَذَا بَلَدُكَ الْحَرَامُ وَحَرَمُكَ وَأَمْنُكَ، فَحَرِّمْ لَحْمِي وَدَمِي وَبَشَرِي عَلَى النَّارِ، وَآمِنِّي مِنْ عَذَابِكَ يَوْمَ تَبْعَثُ عِبَادَكَ، وَاجْعَلْنِي مِنْ أَوْلِيَائِكَ وَأَهْلِ طَاعَتِكَ',
                'transliteration' => 'Allahumma inna hadha baladukal haramu wa haramuka wa amnuka, faharrim lahmi wa dami wa bashari alan-nar, wa aminni min azabika yawma tab\'athu ibadak, waj\'alni min awliya\'ika wa ahli ta\'atik.',
                'translation_en' => 'O Allah, this is Your sacred city, Your sanctuary, and Your place of security. So make my flesh, blood, and skin forbidden to the Fire. Grant me safety from Your punishment on the Day when You raise Your servants, and make me among Your friends and obedient ones.',
                'translation_ur' => 'اے اللہ! یہ تیرا محترم شہر ہے، تیری حرم ہے اور تیری امن کی جگہ ہے۔ تو میرے گوشت، خون اور جسم کو جہنم کی آگ پر حرام کر دے۔ مجھے تیرے عذاب سے اس دن امن دے جب تو اپنے بندوں کو اٹھائے گا، اور مجھے اپنے دوستوں اور فرمانبرداروں میں شامل فرما۔',
                'reference'     => 'Al-Mu\'jam al-Awsat (Tabarani)',
                'is_featured'   => false,
            ],

            // --- UMRAH (category_id: 4) ---
            [
                'category_id'   => 4,
                'title_en'      => 'Niyyah for Umrah',
                'arabic_text'   => 'لَبَّيْكَ اللَّهُمَّ عُمْرَةً',
                'transliteration' => 'Labbaik Allahumma umratan.',
                'translation_en' => 'Here I am, O Allah, for Umrah.',
                'translation_ur' => 'میں حاضر ہوں اے اللہ! عمرہ کے لیے۔',
                'reference'     => 'Sahih al-Bukhari',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 4,
                'title_en'      => 'Dua after finishing Umrah',
                'arabic_text'   => 'اللَّهُمَّ تَقَبَّلْ مِنِّي وَاغْفِرْ لِي وَالْعَفْوَ أَسْأَلُكَ',
                'transliteration' => 'Allahumma taqabbal minni waghfir li wal\'afwa as\'aluk.',
                'translation_en' => 'O Allah, accept from me, forgive me, and I ask You for pardon.',
                'translation_ur' => 'اے اللہ! مجھ سے قبول فرما، مجھے معاف کر اور میں تجھ سے درگزر طلب کرتا ہوں۔',
                'reference'     => 'General Dua',
                'is_featured'   => false,
            ],

            // --- ARAFAT (category_id: 5) ---
            [
                'category_id'   => 5,
                'title_en'      => 'Best Dua on the Day of Arafah',
                'arabic_text'   => 'لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ، وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ',
                'transliteration' => 'La ilaha illallah wahdahu la sharika lah, lahul mulku wa lahul hamdu, wa huwa ala kulli shay-in qadir.',
                'translation_en' => 'There is no god but Allah alone, with no partner. His is the dominion, His is the praise, and He is over all things competent.',
                'translation_ur' => 'اللہ کے سوا کوئی معبود نہیں، وہ اکیلا ہے، اس کا کوئی شریک نہیں۔ اسی کے لیے بادشاہت ہے اور اسی کے لیے تعریف ہے، اور وہ ہر چیز پر قادر ہے۔',
                'reference'     => 'Sunan al-Tirmidhi (The Prophet ﷺ said: The best dua is on the day of Arafah)',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 5,
                'title_en'      => 'Comprehensive Dua for Arafah',
                'arabic_text'   => 'اللَّهُمَّ لَكَ الْحَمْدُ كَالَّذِي نَقُولُ وَخَيْرًا مِمَّا نَقُولُ، اللَّهُمَّ لَكَ صَلَاتِي وَنُسُكِي وَمَحْيَايَ وَمَمَاتِي وَإِلَيْكَ مَآبِي وَلَكَ رَبِّ تُرَاثِي، اللَّهُمَّ إِنِّي أَعُوذُ بِكَ مِنْ عَذَابِ الْقَبْرِ وَوَسْوَسَةِ الصَّدْرِ وَشَتَّاتِ الْأَمْرِ، اللَّهُمَّ إِنِّي أَسْأَلُكَ مِنْ خَيْرِ مَا تَأْتِي بِهِ الرِّيَاحُ، وَأَعُوذُ بِكَ مِنْ شَرِّ مَا تَأْتِي بِهِ الرِّيَاحُ',
                'transliteration' => 'Allahumma lakal hamdu kalladhi naqulu wa khayran mimma naqul. Allahumma laka salati wa nusuki wa mahyaya wa mamati wa ilayka ma\'abi wa laka rabbi turathi. Allahumma inni a\'udhu bika min adhabil qabri wa waswasatis sadri wa shatatil amr. Allahumma inni as\'aluka min khayri ma ta\'ti bihir riyah, wa a\'udhu bika min sharri ma ta\'ti bihir riyah.',
                'translation_en' => 'O Allah, to You be praise as we say and better than what we say. O Allah, to You be my prayer, my sacrifice, my life and my death, and to You is my return. O Allah, I seek refuge in You from the punishment of the grave, the whispers of the heart, and the scattering of affairs. O Allah, I ask You for the good of what the winds bring, and I seek refuge in You from the evil of what the winds bring.',
                'translation_ur' => 'اے اللہ! تیرے لیے تعریف ہے جیسا کہ ہم کہتے ہیں اور اس سے بھی بہتر جو ہم کہہ سکیں۔ اے اللہ! تیرے لیے میری نماز، میری قربانی، میری زندگی اور میری موت ہے، اور تیری ہی طرف میرا لوٹنا ہے۔ اے اللہ! میں تجھ سے پناہ مانگتا ہوں قبر کے عذاب سے، سینے کے وسوسوں سے اور معاملات کے بکھرنے سے۔ اے اللہ! میں تجھ سے بھلائی مانگتا ہوں ان چیزوں کی جو ہوائیں لے کر آتی ہیں، اور پناہ مانگتا ہوں برائی سے ان چیزوں کی جو ہوائیں لے کر آتی ہیں۔',
                'reference'     => 'Sahih Muslim & Ibn Majah',
                'is_featured'   => true,
            ],

            // --- MUZDALIFAH & MINA (category_id: 6) ---
            [
                'category_id'   => 6,
                'title_en'      => 'Dua at Muzdalifah',
                'arabic_text'   => 'اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ وَاغْفِرْ لِي وَارْحَمْنِي',
                'transliteration' => 'Allahummaftah li abwaba rahmatika waghfir li warhamni.',
                'translation_en' => 'O Allah, open for me the doors of Your mercy, forgive me, and have mercy on me.',
                'translation_ur' => 'اے اللہ! میرے لیے اپنی رحمت کے دروازے کھول دے، مجھے معاف کر اور مجھ پر رحم فرما۔',
                'reference'     => 'Sahih al-Bukhari (practice of the Prophet)',
                'is_featured'   => false,
            ],
            [
                'category_id'   => 6,
                'title_en'      => 'Dua during Rami (Stoning the Jamarat)',
                'arabic_text'   => 'بِسْمِ اللَّهِ وَاللَّهُ أَكْبَرُ، رَجْمًا لِلشَّيَاطِينِ وَرِضًا لِلرَّحْمَنِ',
                'transliteration' => 'Bismillahi wallahu akbar. Rajman lish-shayateeni wa ridan lir-Rahman.',
                'translation_en' => 'In the name of Allah, Allah is the Greatest. (This is a) stoning of the devils and seeking the pleasure of the Most Merciful.',
                'translation_ur' => 'اللہ کے نام سے، اللہ سب سے بڑا ہے۔ شیاطین کو سنگسار کرتا ہوں اور رحمن کی رضا کے لیے۔',
                'reference'     => 'Practice of the Prophet ﷺ (Al-Bukhari & Muslim)',
                'is_featured'   => true,
            ],
            [
                'category_id'   => 6,
                'title_en'      => 'Dua after Rami (at Mina)',
                'arabic_text'   => 'اللَّهُمَّ اجْعَلْهُ حَجًّا مَبْرُورًا وَذَنْبًا مَغْفُورًا وَسَعْيًا مَشْكُورًا',
                'transliteration' => 'Allahummaj\'alhu hajjan mabruraw wa zanban maghfura wa sa\'yan mashkura.',
                'translation_en' => 'O Allah, make this an accepted Hajj, forgiven sins, and a thankful effort.',
                'translation_ur' => 'اے اللہ! اسے مقبول حج، بخشے گئے گناہ اور شکر کیے جانے والی کوشش بنا۔',
                'reference'     => 'Authentic Dua from Hadith',
                'is_featured'   => false,
            ],

            // --- GENERAL SUPPLICATIONS (category_id: 7) ---
            [
                'category_id'   => 7,
                'title_en'      => 'Dua for leaving home',
                'arabic_text'   => 'بِسْمِ اللَّهِ، تَوَكَّلْتُ عَلَى اللَّهِ، وَلَا حَوْلَ وَلَا قُوَّةَ إِلَّا بِاللَّهِ',
                'transliteration' => 'Bismillahi, tawakkaltu alallah, wa la hawla wa la quwwata illa billah.',
                'translation_en' => 'In the name of Allah, I put my trust in Allah, and there is no power nor strength except with Allah.',
                'translation_ur' => 'اللہ کے نام سے، میں نے اللہ پر بھروسہ کیا، اور اللہ کے بغیر نہ کوئی طاقت ہے نہ قوت۔',
                'reference'     => 'Sunan Abi Dawud & Tirmidhi',
                'is_featured'   => false,
            ],
            [
                'category_id'   => 7,
                'title_en'      => 'Dua for traveling',
                'arabic_text'   => 'اللَّهُ أَكْبَرُ، اللَّهُ أَكْبَرُ، اللَّهُ أَكْبَرُ، سُبْحَانَ الَّذِي سَخَّرَ لَنَا هَذَا وَمَا كُنَّا لَهُ مُقْرِنِينَ، وَإِنَّا إِلَى رَبِّنَا لَمُنْقَلِبُونَ',
                'transliteration' => 'Allahu akbar, Allahu akbar, Allahu akbar. Subhanalladhi sakhkhara lana hadha wa ma kunna lahu muqrinin, wa inna ila Rabbina lamunqalibun.',
                'translation_en' => 'Allah is the Greatest, Allah is the Greatest, Allah is the Greatest. Glory be to Him Who has subjected this to us, and we could not have done it on our own. And indeed, to our Lord we will return.',
                'translation_ur' => 'اللہ سب سے بڑا ہے، اللہ سب سے بڑا ہے، اللہ سب سے بڑا ہے۔ پاک ہے وہ ذات جس نے اسے ہمارے تابع کر دیا اور ہم اسے قابو کرنے والے نہ تھے، اور بے شک ہم اپنے رب کی طرف لوٹنے والے ہیں۔',
                'reference'     => 'Sahih Muslim (43/13)',
                'is_featured'   => false,
            ],
            [
                'category_id'   => 7,
                'title_en'      => 'Dua for entering a market/mosque',
                'arabic_text'   => 'اللَّهُمَّ إِنِّي أَسْأَلُكَ مِنْ فَضْلِكَ، اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ',
                'transliteration' => 'Allahumma inni as\'aluka min fadlik. Allahummaftah li abwaba rahmatik.',
                'translation_en' => 'O Allah, I ask You of Your bounty. O Allah, open for me the doors of Your mercy.',
                'translation_ur' => 'اے اللہ! میں تجھ سے تیرا فضل مانگتا ہوں۔ اے اللہ! میرے لیے اپنی رحمت کے دروازے کھول دے۔',
                'reference'     => 'Sahih Muslim & Sunan Ibn Majah',
                'is_featured'   => false,
            ],
        ];

        foreach ($duas as $dua) {
            Dua::updateOrCreate(
                ['title_en' => $dua['title_en']],
                $dua
            );
        }

        $this->command->info('✅ ' . count($duas) . ' authentic Duas seeded!');

        // =============================================
        // NIYAT (Intentions)
        // =============================================
        $niyat = [
            [
                'type'          => 'umrah',
                'title_en'      => 'Niyat for Umrah',
                'arabic_text'   => 'لَبَّيْكَ اللَّهُمَّ عُمْرَةً',
                'transliteration' => 'Labbaik Allahumma umratan.',
                'translation_en' => 'O Allah, here I am to perform Umrah.',
                'translation_ur' => 'اے اللہ! میں حاضر ہوں عمرہ کے لیے۔',
            ],
            [
                'type'          => 'hajj',
                'title_en'      => 'Niyat for Hajj',
                'arabic_text'   => 'لَبَّيْكَ اللَّهُمَّ حَجًّا',
                'transliteration' => 'Labbaik Allahumma hajjan.',
                'translation_en' => 'O Allah, here I am to perform Hajj.',
                'translation_ur' => 'اے اللہ! میں حاضر ہوں حج کے لیے۔',
            ],
            [
                'type'          => 'hajj_umrah',
                'title_en'      => 'Niyat for Hajj and Umrah Combined (Qiran)',
                'arabic_text'   => 'لَبَّيْكَ اللَّهُمَّ حَجًّا وَعُمْرَةً',
                'transliteration' => 'Labbaik Allahumma hajjan wa umratan.',
                'translation_en' => 'O Allah, here I am to perform Hajj and Umrah together.',
                'translation_ur' => 'اے اللہ! میں حاضر ہوں حج اور عمرہ دونوں کے لیے۔',
            ],
        ];

        foreach ($niyat as $n) {
            Niyat::updateOrCreate(
                ['title_en' => $n['title_en']],
                $n
            );
        }

        $this->command->info('✅ ' . count($niyat) . ' Niyat seeded!');
    }
}