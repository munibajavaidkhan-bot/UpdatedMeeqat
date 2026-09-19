<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChaddarSizeRule;

class ChaddarSizeRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [

            // ========== FULL STYLE ==========
            [
                'style'          => 'full',
                'height_min_cm'  => 140.00,
                'height_max_cm'  => 155.00,
                'fabric_meters'  => 3.50,
                'size_label'     => 'XS',
                'description'    => 'Extra Small — 140cm to 155cm height',
                'is_active'      => true,
            ],
            [
                'style'          => 'full',
                'height_min_cm'  => 155.01,
                'height_max_cm'  => 165.00,
                'fabric_meters'  => 4.00,
                'size_label'     => 'S',
                'description'    => 'Small — 155cm to 165cm height',
                'is_active'      => true,
            ],
            [
                'style'          => 'full',
                'height_min_cm'  => 165.01,
                'height_max_cm'  => 172.00,
                'fabric_meters'  => 4.25,
                'size_label'     => 'M',
                'description'    => 'Medium — 165cm to 172cm height',
                'is_active'      => true,
            ],
            [
                'style'          => 'full',
                'height_min_cm'  => 172.01,
                'height_max_cm'  => 178.00,
                'fabric_meters'  => 4.50,
                'size_label'     => 'L',
                'description'    => 'Large — 172cm to 178cm height',
                'is_active'      => true,
            ],
            [
                'style'          => 'full',
                'height_min_cm'  => 178.01,
                'height_max_cm'  => 185.00,
                'fabric_meters'  => 5.00,
                'size_label'     => 'XL',
                'description'    => 'Extra Large — 178cm to 185cm height',
                'is_active'      => true,
            ],
            [
                'style'          => 'full',
                'height_min_cm'  => 185.01,
                'height_max_cm'  => 200.00,
                'fabric_meters'  => 5.50,
                'size_label'     => 'XXL',
                'description'    => 'Double Extra Large — 185cm+ height',
                'is_active'      => true,
            ],

            // ========== SHOULDER STYLE ==========
            [
                'style'          => 'shoulder',
                'height_min_cm'  => 140.00,
                'height_max_cm'  => 155.00,
                'fabric_meters'  => 2.50,
                'size_label'     => 'XS',
                'description'    => 'Extra Small Shoulder — 140cm to 155cm',
                'is_active'      => true,
            ],
            [
                'style'          => 'shoulder',
                'height_min_cm'  => 155.01,
                'height_max_cm'  => 165.00,
                'fabric_meters'  => 2.75,
                'size_label'     => 'S',
                'description'    => 'Small Shoulder — 155cm to 165cm',
                'is_active'      => true,
            ],
            [
                'style'          => 'shoulder',
                'height_min_cm'  => 165.01,
                'height_max_cm'  => 172.00,
                'fabric_meters'  => 3.00,
                'size_label'     => 'M',
                'description'    => 'Medium Shoulder — 165cm to 172cm',
                'is_active'      => true,
            ],
            [
                'style'          => 'shoulder',
                'height_min_cm'  => 172.01,
                'height_max_cm'  => 178.00,
                'fabric_meters'  => 3.25,
                'size_label'     => 'L',
                'description'    => 'Large Shoulder — 172cm to 178cm',
                'is_active'      => true,
            ],
            [
                'style'          => 'shoulder',
                'height_min_cm'  => 178.01,
                'height_max_cm'  => 185.00,
                'fabric_meters'  => 3.50,
                'size_label'     => 'XL',
                'description'    => 'Extra Large Shoulder — 178cm to 185cm',
                'is_active'      => true,
            ],
            [
                'style'          => 'shoulder',
                'height_min_cm'  => 185.01,
                'height_max_cm'  => 200.00,
                'fabric_meters'  => 4.00,
                'size_label'     => 'XXL',
                'description'    => 'Double Extra Large Shoulder — 185cm+',
                'is_active'      => true,
            ],
        ];

        foreach ($rules as $rule) {
            ChaddarSizeRule::updateOrCreate(
                ['style' => $rule['style'], 'size_label' => $rule['size_label']],
                $rule
            );
        }

        $this->command->info('✅ Chaddar Size Rules seeded! (12 rules — Full & Shoulder styles)');
    }
}