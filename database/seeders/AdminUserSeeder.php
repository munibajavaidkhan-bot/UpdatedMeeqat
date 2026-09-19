<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'admin@meeqat.io'],
            [
                'name'              => 'Super Admin',
                'email'             => 'admin@meeqat.io',
                'phone'             => '+92300000001',
                'password'          => Hash::make('Admin@12345'),
                'role_id'           => 1,
                'country'           => 'Pakistan',
                'city'              => 'Karachi',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        // Content Editor
        User::updateOrCreate(
            ['email' => 'editor@meeqat.io'],
            [
                'name'              => 'Content Editor',
                'email'             => 'editor@meeqat.io',
                'phone'             => '+92300000002',
                'password'          => Hash::make('Editor@12345'),
                'role_id'           => 2,
                'country'           => 'Pakistan',
                'city'              => 'Lahore',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        // Test Pilgrim User
        User::updateOrCreate(
            ['email' => 'user@meeqat.io'],
            [
                'name'              => 'Test Pilgrim',
                'email'             => 'user@meeqat.io',
                'phone'             => '+92300000003',
                'password'          => Hash::make('User@12345'),
                'role_id'           => 3,
                'country'           => 'Pakistan',
                'city'              => 'Islamabad',
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin, Editor & Test User seeded!');
        $this->command->table(
            ['Role', 'Email'],
            [
                ['Super Admin',    'admin@meeqat.io'],
                ['Content Editor', 'editor@meeqat.io'],
                ['Pilgrim User',   'user@meeqat.io'],
            ]
        );
        $this->command->warn('⚠ Default passwords are set. Change them in production!');
    }
}