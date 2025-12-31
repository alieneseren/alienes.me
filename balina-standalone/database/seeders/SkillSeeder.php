<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            ['name' => 'PHP', 'category' => 'Programlama Dilleri', 'proficiency' => 95],
            ['name' => 'JavaScript', 'category' => 'Programlama Dilleri', 'proficiency' => 90],
            ['name' => 'Python', 'category' => 'Programlama Dilleri', 'proficiency' => 75],
            ['name' => 'TypeScript', 'category' => 'Programlama Dilleri', 'proficiency' => 85],
            
            ['name' => 'Laravel', 'category' => 'Framework & Kütüphaneler', 'proficiency' => 95],
            ['name' => 'Vue.js', 'category' => 'Framework & Kütüphaneler', 'proficiency' => 88],
            ['name' => 'React', 'category' => 'Framework & Kütüphaneler', 'proficiency' => 82],
            ['name' => 'Node.js', 'category' => 'Framework & Kütüphaneler', 'proficiency' => 80],
            ['name' => 'Tailwind CSS', 'category' => 'Framework & Kütüphaneler', 'proficiency' => 92],
            
            ['name' => 'MySQL', 'category' => 'Veritabanı', 'proficiency' => 90],
            ['name' => 'PostgreSQL', 'category' => 'Veritabanı', 'proficiency' => 85],
            ['name' => 'MongoDB', 'category' => 'Veritabanı', 'proficiency' => 75],
            ['name' => 'Redis', 'category' => 'Veritabanı', 'proficiency' => 80],
            
            ['name' => 'Git', 'category' => 'Araçlar & DevOps', 'proficiency' => 92],
            ['name' => 'Docker', 'category' => 'Araçlar & DevOps', 'proficiency' => 85],
            ['name' => 'Linux', 'category' => 'Araçlar & DevOps', 'proficiency' => 88],
            ['name' => 'AWS', 'category' => 'Araçlar & DevOps', 'proficiency' => 75],
            ['name' => 'CI/CD', 'category' => 'Araçlar & DevOps', 'proficiency' => 80],
        ];

        foreach ($skills as $index => $skill) {
            Skill::create(array_merge($skill, ['order' => $index + 1]));
        }
    }
}
