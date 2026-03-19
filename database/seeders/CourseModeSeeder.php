<?php

namespace Database\Seeders;

use App\Models\CourseMode;
use Illuminate\Database\Seeder;

class CourseModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modes = [
            ['name' => 'Online/Means', 'description' => 'Fully online or remote delivery'],
            ['name' => 'Physical', 'description' => 'In-person / on-campus delivery'],
        ];

        foreach ($modes as $mode) {
            CourseMode::firstOrCreate(
                ['name' => $mode['name']],
                ['description' => $mode['description'], 'is_active' => true]
            );
        }
    }
}
