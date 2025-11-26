<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        Education::create([
            'school' => 'İstanbul Teknik Üniversitesi',
            'degree' => 'Lisans',
            'field_of_study' => 'Bilgisayar Mühendisliği',
            'start_date' => '2015-09-01',
            'end_date' => '2019-06-30',
            'is_current' => false,
            'description' => 'Yazılım geliştirme, algoritma tasarımı, veri yapıları ve veritabanı yönetimi konularında eğitim aldım.',
            'gpa' => 3.45,
            'order' => 1,
        ]);

        Education::create([
            'school' => 'Anadolu Lisesi',
            'degree' => 'Lise Diploması',
            'field_of_study' => 'Fen Bilimleri',
            'start_date' => '2011-09-01',
            'end_date' => '2015-06-30',
            'is_current' => false,
            'gpa' => 4.00,
            'order' => 2,
        ]);
    }
}
