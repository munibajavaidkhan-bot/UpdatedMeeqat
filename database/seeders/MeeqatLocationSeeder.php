<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeeqatLocation;
use Illuminate\Support\Str;

class MeeqatLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'id'                => 1,
                'name_en'           => 'Dhul Hulayfah (Abyar Ali)',
                'name_ar'           => 'ذو الحليفة (آبار علي)',
                'name_ur'           => 'ذوالحلیفہ (آبار علی)',
                'description'       => 'The Meeqat for people coming from Madinah and those who pass through it. Located about 9km from Madinah.',
                'description_ur'    => 'مدینہ منورہ سے آنے والوں کے لیے میقات۔ مدینہ سے تقریباً 9 کلومیٹر دور واقع ہے۔',
                'latitude'          => 24.41559000,
                'longitude'         => 39.54187000,
                'for_pilgrims_from' => 'Pakistan, India, Turkey, UK, USA (via Madinah route)',
                'color'             => '#22c55e',
                'icon'              => '🟢',
                'sort_order'        => 1,
                'is_active'         => true,
            ],
            [
                'id'                => 2,
                'name_en'           => 'Al-Juhfah (Rabigh)',
                'name_ar'           => 'الجُحفة (رابغ)',
                'name_ur'           => 'الجحفہ (رابغ)',
                'description'       => 'Meeqat for pilgrims from Syria, Egypt, Morocco, and those who pass through it. Currently Rabigh is used.',
                'description_ur'    => 'شام، مصر، مراکش اور اس راستے سے گزرنے والوں کے لیے میقات۔',
                'latitude'          => 22.56920000,
                'longitude'         => 39.03580000,
                'for_pilgrims_from' => 'Syria, Egypt, Morocco, Jordan, Palestine, Algeria, Tunisia',
                'color'             => '#059669',
                'icon'              => '🔵',
                'sort_order'        => 2,
                'is_active'         => true,
            ],
            [
                'id'                => 3,
                'name_en'           => 'Qarn al-Manazil (As-Sayl)',
                'name_ar'           => 'قَرن المنازل (السيل الكبير)',
                'name_ur'           => 'قرن المنازل (السیل الکبیر)',
                'description'       => 'Meeqat for people from Najd, UAE, Oman and those coming from that direction.',
                'description_ur'    => 'نجد، متحدہ عرب امارات، عمان اور اس سمت سے آنے والوں کے لیے میقات۔',
                'latitude'          => 21.28330000,
                'longitude'         => 40.41670000,
                'for_pilgrims_from' => 'UAE, Oman, Bahrain, Kuwait, Qatar, Afghanistan (eastern route)',
                'color'             => '#10b981',
                'icon'              => '🟡',
                'sort_order'        => 3,
                'is_active'         => true,
            ],
            [
                'id'                => 4,
                'name_en'           => 'Yalamlam (As-Sa\'diyah)',
                'name_ar'           => 'يَلَمْلَم (السعدية)',
                'name_ur'           => 'یلملم (السعدیہ)',
                'description'       => 'Meeqat for pilgrims from Yemen and those coming from that direction including Pakistan by sea.',
                'description_ur'    => 'یمن اور اس سمت سے آنے والوں کے لیے میقات۔ سمندری راستے سے پاکستان کے لیے بھی۔',
                // Miqat Yalamlam (As-Sa'diyyah), south of Makkah.
                // The previous coordinates pointed into Yemen, which made every
                // distance to this Meeqat materially incorrect.
                'latitude'          => 20.51732400,
                'longitude'         => 39.87108300,
                'for_pilgrims_from' => 'Yemen, Pakistan (by sea), India (by sea), Indonesia (by sea)',
                'color'             => '#34d399',
                'icon'              => '🟣',
                'sort_order'        => 4,
                'is_active'         => true,
            ],
            [
                'id'                => 5,
                'name_en'           => 'Dhat Irq (Al-Dharibah)',
                'name_ar'           => 'ذات عِرق (الضريبة)',
                'name_ur'           => 'ذات عرق (الضریبہ)',
                'description'       => 'Meeqat for people from Iraq and those coming from that direction.',
                'description_ur'    => 'عراق اور اس سمت سے آنے والوں کے لیے میقات۔',
                'latitude'          => 21.93013000,
                'longitude'         => 40.42565000,
                'for_pilgrims_from' => 'Iraq, Iran, Kuwait (northern route)',
                'color'             => '#047857',
                'icon'              => '🔴',
                'sort_order'        => 5,
                'is_active'         => true,
            ],
        ];

        foreach ($locations as $location) {
            MeeqatLocation::updateOrCreate(
                ['id' => $location['id']],
                $location
            );
        }

        $this->command->info('✅ 5 Meeqat Locations seeded successfully!');
        $this->command->table(
            ['ID', 'Name', 'Lat', 'Lng', 'For Pilgrims From'],
            collect($locations)->map(fn($l) => [
                $l['id'],
                $l['name_en'],
                $l['latitude'],
                $l['longitude'],
                Str::limit($l['for_pilgrims_from'], 40),
            ])->toArray()
        );
    }
}
