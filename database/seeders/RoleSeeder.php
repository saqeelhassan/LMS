<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'SuperAdmin', 'description' => 'Super administrator with full control over the platform'],
            ['name' => 'Student', 'description' => 'Student role for course enrollment and learning'],
            ['name' => 'Admin', 'description' => 'Administrator with full system access'],
            ['name' => 'Instructor', 'description' => 'Instructor role for creating and teaching courses'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description'], 'is_active' => true]
            );
        }
    }
}
