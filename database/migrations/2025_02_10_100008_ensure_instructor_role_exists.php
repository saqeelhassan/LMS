<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Ensure Instructor (and Admin, Student) roles exist for super-admin user management.
     */
    public function up(): void
    {
        $roles = [
            ['name' => 'Instructor', 'description' => 'Instructor role for creating and teaching courses'],
            ['name' => 'Admin', 'description' => 'Administrator with assigned permissions'],
            ['name' => 'Student', 'description' => 'Student role for course enrollment and learning'],
        ];

        foreach ($roles as $role) {
            if (DB::table('roles')->where('name', $role['name'])->doesntExist()) {
                DB::table('roles')->insert([
                    'name' => $role['name'],
                    'description' => $role['description'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Do not remove roles in down() - other data may reference them
    }
};
