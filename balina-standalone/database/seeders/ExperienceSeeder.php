<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        Experience::create([
            'company' => 'Tech Solutions Ltd.',
            'position' => 'Senior Full Stack Developer',
            'location' => 'İstanbul, Türkiye',
            'start_date' => '2022-01-01',
            'is_current' => true,
            'description' => 'Modern web uygulamaları geliştirme, Laravel ve Vue.js kullanarak ölçeklenebilir sistemler oluşturma. Takım liderliği ve kod review süreçlerinde aktif rol alma.',
            'order' => 1,
        ]);

        Experience::create([
            'company' => 'Digital Agency',
            'position' => 'Full Stack Developer',
            'location' => 'İstanbul, Türkiye',
            'start_date' => '2020-06-01',
            'end_date' => '2021-12-31',
            'is_current' => false,
            'description' => 'Müşteri projeleri için web uygulamaları geliştirme, REST API tasarımı ve implementasyonu. Frontend ve backend entegrasyonları.',
            'order' => 2,
        ]);

        Experience::create([
            'company' => 'StartUp Inc.',
            'position' => 'Junior Developer',
            'location' => 'Ankara, Türkiye',
            'start_date' => '2019-03-01',
            'end_date' => '2020-05-31',
            'is_current' => false,
            'description' => 'Web geliştirme projelerinde yer alma, bug fixing, kod optimizasyonu ve yeni özellik geliştirme.',
            'order' => 3,
        ]);
    }
}
