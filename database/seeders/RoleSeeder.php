<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id'          => 1,
                'name'        => 'admin',
                'label'       => 'Super Admin',
                'description' => 'Full system access with all permissions',
            ],
            [
                'id'          => 2,
                'name'        => 'editor',
                'label'       => 'Content Editor',
                'description' => 'Can manage content but not users or settings',
            ],
            [
                'id'          => 3,
                'name'        => 'user',
                'label'       => 'Pilgrim',
                'description' => 'Regular user - can use all tools and save data',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }

        $this->command->info('✅ Roles seeded successfully!');
    }
}