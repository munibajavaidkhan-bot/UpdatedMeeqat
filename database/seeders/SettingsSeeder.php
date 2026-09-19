<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name',        'value' => 'Meeqat.io',                     'type' => 'text',    'group' => 'general',  'label' => 'Site Name'],
            ['key' => 'site_tagline',     'value' => 'Smart Hajj & Umrah Companion',   'type' => 'text',    'group' => 'general',  'label' => 'Site Tagline'],
            ['key' => 'site_email',       'value' => 'info@meeqat.io',                 'type' => 'text',    'group' => 'general',  'label' => 'Contact Email'],
            ['key' => 'site_phone',       'value' => '+92 300 0000000',                'type' => 'text',    'group' => 'general',  'label' => 'Contact Phone'],
            ['key' => 'site_logo',        'value' => null,                             'type' => 'image',   'group' => 'general',  'label' => 'Site Logo'],
            ['key' => 'site_favicon',     'value' => null,                             'type' => 'image',   'group' => 'general',  'label' => 'Favicon'],

            // SEO
            ['key' => 'meta_description', 'value' => 'Smart tools for Hajj & Umrah pilgrims', 'type' => 'text', 'group' => 'seo', 'label' => 'Meta Description'],
            ['key' => 'meta_keywords',    'value' => 'hajj, umrah, meeqat, duas, ihram',       'type' => 'text', 'group' => 'seo', 'label' => 'Meta Keywords'],

            // Features
            ['key' => 'enable_tryon',     'value' => '1',   'type' => 'boolean', 'group' => 'features', 'label' => 'Enable Virtual Try-On'],
            ['key' => 'enable_audio',     'value' => '1',   'type' => 'boolean', 'group' => 'features', 'label' => 'Enable Dua Audio'],
            ['key' => 'guest_calculator', 'value' => '1',   'type' => 'boolean', 'group' => 'features', 'label' => 'Allow Guest Calculator'],

            // Social
            ['key' => 'facebook_url',     'value' => '',    'type' => 'text',    'group' => 'social',   'label' => 'Facebook URL'],
            ['key' => 'instagram_url',    'value' => '',    'type' => 'text',    'group' => 'social',   'label' => 'Instagram URL'],
            ['key' => 'youtube_url',      'value' => '',    'type' => 'text',    'group' => 'social',   'label' => 'YouTube URL'],
        ];

        foreach ($settings as $setting) {
            \DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Settings seeded!');
    }
}