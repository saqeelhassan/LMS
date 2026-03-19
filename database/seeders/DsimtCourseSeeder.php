<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseMode;
use Illuminate\Database\Seeder;

class DsimtCourseSeeder extends Seeder
{
    /**
     * Course names for the LMS (used by course list and enrollment).
     */
    public function run(): void
    {
        $online = CourseMode::where('name', 'Online/Means')->first();
        $physical = CourseMode::where('name', 'Physical')->first();
        $modeId = $online?->id ?? $physical?->id;
        if (! $modeId) {
            return;
        }

        $courses = [
            // Featured (dsimt/courses)
            ['name' => 'Web Development With Python Programming', 'description' => 'Learn web development with Python.'],
            ['name' => 'DIT & CIT', 'description' => 'Diploma and Certificate in Information Technology – TTB Board.'],
            ['name' => 'Amazon(Virtual Assistant)', 'description' => 'Amazon Virtual Assistant training.'],
            ['name' => 'Web Development', 'description' => 'Web development fundamentals.'],
            ['name' => 'Digital Marketing', 'description' => 'Digital marketing from scratch.'],
            ['name' => 'Graphic Design', 'description' => 'Create stunning designs with industry-standard tools.'],
            ['name' => 'Video Editing', 'description' => 'Professional video editing.'],
            ['name' => 'UI & UX Design', 'description' => 'User interface and user experience design.'],
            ['name' => 'Trading', 'description' => 'Trading fundamentals.'],
            // Board (dsimt/board-courses)
            ['name' => 'Diploma in Information Technology', 'description' => 'Diploma in IT – TTB Board.'],
            ['name' => 'Mobile Application Development', 'description' => 'NAVTTC Mobile Application Development.'],
            ['name' => 'Certificate in Information Technology', 'description' => 'Certificate in IT – TTB Board.'],
            // Special
            ['name' => 'Web Development Crash Course', 'description' => 'Web development crash course.'],
            ['name' => 'Graphic Design Crash Course', 'description' => 'Graphic design crash course.'],
            // Scholarship (duplicate names exist on site; we use same LMS course)
            ['name' => 'Web Design', 'description' => 'Web design scholarship course.'],
        ];

        foreach ($courses as $data) {
            Course::firstOrCreate(
                ['name' => $data['name']],
                [
                    'course_mode_id' => $modeId,
                    'description' => $data['description'] ?? null,
                ]
            );
        }
    }
}
