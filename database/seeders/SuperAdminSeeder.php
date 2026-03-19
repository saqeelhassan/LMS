<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create the single Super Admin user (managed in code only; not shown in panel).
     * Set SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD in .env to customize.
     */
    public function run(): void
    {
        $role = Role::where('name', 'SuperAdmin')->first();
        if (! $role) {
            return;
        }

        $email = trim(env('SUPERADMIN_EMAIL', 'Aqeel@deweboo.com'));
        $password = env('SUPERADMIN_PASSWORD', '0336@Aqeel');

        // updateOrCreate so password is always set when you run the seeder (fixes login)
        $user = User::updateOrCreate(
            ['email' => strtolower($email)],
            [
                'role_id' => $role->id,
                'password' => bcrypt($password),
                'is_active' => true,
            ]
        );

        UserDetail::firstOrCreate(
            ['user_id' => $user->id],
            ['first_name' => 'Super', 'last_name' => 'Admin']
        );
    }
}
