<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Users Module
            ['name' => 'manage_users',      'label' => 'Manage Users',          'module' => 'users'],
            ['name' => 'view_users',         'label' => 'View Users',             'module' => 'users'],

            // Content Module
            ['name' => 'manage_duas',        'label' => 'Manage Duas & Niyat',   'module' => 'content'],
            ['name' => 'manage_guides',      'label' => 'Manage Ihram Guides',   'module' => 'content'],
            ['name' => 'manage_products',    'label' => 'Manage Products',        'module' => 'content'],
            ['name' => 'manage_faqs',        'label' => 'Manage FAQs',           'module' => 'content'],
            ['name' => 'manage_meeqat',      'label' => 'Manage Meeqat Locations','module' => 'content'],

            // Tools Module
            ['name' => 'use_calculator',     'label' => 'Use Calculators',        'module' => 'tools'],
            ['name' => 'save_results',       'label' => 'Save Tool Results',      'module' => 'tools'],
            ['name' => 'use_tryon',          'label' => 'Use Virtual Try-On',     'module' => 'tools'],
            ['name' => 'bookmark_duas',      'label' => 'Bookmark Duas',          'module' => 'tools'],

            // Analytics Module
            ['name' => 'view_analytics',     'label' => 'View Analytics',         'module' => 'analytics'],
            ['name' => 'view_logs',          'label' => 'View Activity Logs',     'module' => 'analytics'],

            // Settings Module
            ['name' => 'manage_settings',    'label' => 'Manage Settings',        'module' => 'settings'],
            ['name' => 'manage_messages',    'label' => 'Manage Contact Messages','module' => 'settings'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm['name']], $perm);
        }

        // Admin ko saari permissions do
        $admin = Role::find(1);
        $allPermissionIds = Permission::pluck('id')->toArray();
        $admin->permissions()->sync($allPermissionIds);

        // Editor ko content permissions do
        $editor = Role::find(2);
        $editorPermissions = Permission::whereIn('name', [
            'manage_duas',
            'manage_guides',
            'manage_products',
            'manage_faqs',
            'manage_meeqat',
            'use_calculator',
            'use_tryon',
        ])->pluck('id')->toArray();
        $editor->permissions()->sync($editorPermissions);

        // User ko tools permissions do
        $user = Role::find(3);
        $userPermissions = Permission::whereIn('name', [
            'use_calculator',
            'save_results',
            'use_tryon',
            'bookmark_duas',
        ])->pluck('id')->toArray();
        $user->permissions()->sync($userPermissions);

        $this->command->info('✅ Permissions seeded and assigned to roles!');
    }
}