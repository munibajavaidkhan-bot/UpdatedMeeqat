<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            AdminUserSeeder::class,
            SettingsSeeder::class,
            ChaddarSizeRuleSeeder::class,
            MeeqatLocationSeeder::class,
            DuaNiyatSeeder::class,
            IhramGuideSeeder::class,
        ]);
    }
}