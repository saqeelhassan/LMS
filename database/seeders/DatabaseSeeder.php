<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CourseModeSeeder::class,
            PaymentMethodSeeder::class,
            CourseSeeder::class,
            DsimtCourseSeeder::class,
            SuperAdminSeeder::class,
        ]);

        $adminRole = Role::where('name', 'Admin')->first();

        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['role_id' => $adminRole?->id, 'password' => bcrypt('password'), 'is_active' => true]
        );

        UserDetail::firstOrCreate(
            ['user_id' => $user->id],
            ['first_name' => 'Test', 'last_name' => 'User']
        );
    }
}
