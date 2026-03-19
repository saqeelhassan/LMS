<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseMode;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $online = CourseMode::where('name', 'Online/Means')->first();
        $physical = CourseMode::where('name', 'Physical')->first();

        if (! $online || ! $physical) {
            return;
        }

        $courses = [
            ['name' => 'Digital Marketing Masterclass', 'course_mode_id' => $online->id, 'description' => 'Learn digital marketing from scratch.'],
            ['name' => 'Graphic Design Masterclass', 'course_mode_id' => $online->id, 'description' => 'Create stunning designs with industry-standard tools.'],
            ['name' => 'The Complete Web Development in Python', 'course_mode_id' => $online->id, 'description' => 'Build web applications with Python and Django.'],
            ['name' => 'Building Scalable APIs with GraphQL', 'course_mode_id' => $online->id, 'description' => 'Design and implement GraphQL APIs.'],
            ['name' => 'Bootstrap 5 From Scratch', 'course_mode_id' => $online->id, 'description' => 'Master responsive design with Bootstrap 5.'],
            ['name' => 'Angular – The Complete Guide', 'course_mode_id' => $online->id, 'description' => 'Build modern web apps with Angular.'],
            ['name' => 'Physical Workshop: Leadership Skills', 'course_mode_id' => $physical->id, 'description' => 'In-person leadership and communication training.'],
            ['name' => 'On-Campus: Data Science Fundamentals', 'course_mode_id' => $physical->id, 'description' => 'Hands-on data science at our campus.'],
        ];

        foreach ($courses as $data) {
            Course::firstOrCreate(
                ['name' => $data['name']],
                ['course_mode_id' => $data['course_mode_id'], 'description' => $data['description']]
            );
        }
    }
}
