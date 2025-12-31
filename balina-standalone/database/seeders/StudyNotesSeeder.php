<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyCategory;
use App\Models\StudyNote;

class StudyNotesSeeder extends Seeder
{
    public function run(): void
    {
        // Kategorileri oluştur
        $mikroislemciler = StudyCategory::create([
            'name' => 'Mikroişlemciler',
            'slug' => 'mikroislemciler',
            'description' => 'Mikroişlemciler ve Gömülü Sistemler ders notları',
            'icon' => '💻',
            'order' => 1,
            'is_active' => true,
        ]);

        $otomata = StudyCategory::create([
            'name' => 'Otomata Teorisi',
            'slug' => 'otomata',
            'description' => 'Otomata Teorisi ve Biçimsel Diller ders notları',
            'icon' => '🤖',
            'order' => 2,
            'is_active' => true,
        ]);

        $evrimsel = StudyCategory::create([
            'name' => 'Evrimsel Hesaplama',
            'slug' => 'evrimsel-hesaplama',
            'description' => 'Evrimsel Hesaplama ve Yapay Zeka algoritmaları',
            'icon' => '🧬',
            'order' => 3,
            'is_active' => true,
        ]);

        $siber = StudyCategory::create([
            'name' => 'Siber Güvenlik',
            'slug' => 'siber',
            'description' => 'Siber Güvenlik ve Ağ Güvenliği ders notları',
            'icon' => '🔒',
            'order' => 4,
            'is_active' => true,
        ]);

        $mimari = StudyCategory::create([
            'name' => 'Bilgisayar Mimarisi',
            'slug' => 'bilgisayar-mimarisi',
            'description' => 'Bilgisayar Mimarisi ve Organizasyon ders notları',
            'icon' => '🖥️',
            'order' => 5,
            'is_active' => true,
        ]);

        // Mikroişlemciler notları
        $mikroNotlar = [
            ['title' => 'Modül 1: Giriş', 'file' => 'modul1-giris.html', 'order' => 1],
            ['title' => 'Modül 2: Yarıiletkenler', 'file' => 'modul2-yariletken.html', 'order' => 2],
            ['title' => 'Modül 3: Sayı Sistemleri', 'file' => 'modul3-sayi-sistemleri.html', 'order' => 3],
            ['title' => 'Modül 4: Mimariler', 'file' => 'modul4-mimariler.html', 'order' => 4],
            ['title' => 'Modül 5: Hafıza', 'file' => 'modul5-hafiza.html', 'order' => 5],
            ['title' => 'Modül 6: Veriyolu', 'file' => 'modul6-veriyolu.html', 'order' => 6],
            ['title' => 'Modül 7: Hesaplamalar', 'file' => 'modul7-hesaplamalar.html', 'order' => 7],
            ['title' => 'Modül 8: ESP32', 'file' => 'modul8-esp32.html', 'order' => 8],
            ['title' => 'Formül Özet', 'file' => 'formul-ozet.html', 'order' => 9],
            ['title' => 'Pratik Sorular', 'file' => 'pratik-sorular.html', 'order' => 10],
            ['title' => 'Tüm Testler', 'file' => 'tum-testler.html', 'order' => 11],
            ['title' => 'Flashcards', 'file' => 'flashcards.html', 'order' => 12],
            ['title' => 'Çalışma Sayfası', 'file' => 'calisma.html', 'order' => 13],
        ];

        foreach ($mikroNotlar as $not) {
            StudyNote::create([
                'category_id' => $mikroislemciler->id,
                'title' => $not['title'],
                'slug' => pathinfo($not['file'], PATHINFO_FILENAME),
                'description' => null,
                'file_path' => 'notes/' . $not['file'],
                'type' => 'html',
                'order' => $not['order'],
                'is_active' => true,
            ]);
        }

        // Otomata notları
        $otomataNotlar = [
            ['title' => 'Modül 1: Giriş', 'file' => 'otomata/modul1-giris.html', 'order' => 1],
            ['title' => 'Modül 2: Düzenli İfadeler', 'file' => 'otomata/modul2-duzenli-ifadeler.html', 'order' => 2],
            ['title' => 'Modül 3: Sonlu Otomatlar', 'file' => 'otomata/modul3-sonlu-otomatlar.html', 'order' => 3],
            ['title' => 'Modül 4: Örnekler', 'file' => 'otomata/modul4-ornekler.html', 'order' => 4],
            ['title' => 'Formül Özet', 'file' => 'otomata/formul-ozet.html', 'order' => 5],
            ['title' => 'Pratik Sorular', 'file' => 'otomata/pratik-sorular.html', 'order' => 6],
            ['title' => 'Tüm Testler', 'file' => 'otomata/tum-testler.html', 'order' => 7],
            ['title' => 'Flashcards', 'file' => 'otomata/flashcards.html', 'order' => 8],
        ];

        foreach ($otomataNotlar as $not) {
            StudyNote::create([
                'category_id' => $otomata->id,
                'title' => $not['title'],
                'slug' => pathinfo($not['file'], PATHINFO_FILENAME),
                'description' => null,
                'file_path' => 'notes/' . $not['file'],
                'type' => 'html',
                'order' => $not['order'],
                'is_active' => true,
            ]);
        }

        // Evrimsel Hesaplama notları
        $evrimselNotlar = [
            ['title' => 'Modül 1: Optimizasyon', 'file' => 'evrimsel hesaplama/html/modul1-optimizasyon.html', 'order' => 1],
            ['title' => 'Modül 2: PSO (Parçacık Sürü Optimizasyonu)', 'file' => 'evrimsel hesaplama/html/modul2-pso.html', 'order' => 2],
            ['title' => 'Modül 3: ABC (Yapay Arı Kolonisi)', 'file' => 'evrimsel hesaplama/html/modul3-abc.html', 'order' => 3],
            ['title' => 'Modül 4: Genetik Algoritmalar', 'file' => 'evrimsel hesaplama/html/modul4-genetik.html', 'order' => 4],
            ['title' => 'Modül 5: Diferansiyel Evrim', 'file' => 'evrimsel hesaplama/html/modul5-diferansiyel.html', 'order' => 5],
            ['title' => 'Modül 6: Tavlama Simülasyonu & Tabu Arama', 'file' => 'evrimsel hesaplama/html/modul6-tavlama-tabu.html', 'order' => 6],
            ['title' => 'Modül 7: Karınca Kolonisi Optimizasyonu', 'file' => 'evrimsel hesaplama/html/modul7-karinca.html', 'order' => 7],
        ];

        foreach ($evrimselNotlar as $not) {
            StudyNote::create([
                'category_id' => $evrimsel->id,
                'title' => $not['title'],
                'slug' => pathinfo($not['file'], PATHINFO_FILENAME),
                'description' => null,
                'file_path' => 'notes/' . $not['file'],
                'type' => 'html',
                'order' => $not['order'],
                'is_active' => true,
            ]);
        }

        // Siber Güvenlik notları
        $siberNotlar = [
            ['title' => 'Modül 1: Bash Scripting', 'file' => 'siber/html/modul1-bash.html', 'order' => 1],
            ['title' => 'Modül 2: Kali Linux Komutları', 'file' => 'siber/html/modul2-kali-komutlari.html', 'order' => 2],
            ['title' => 'Modül 3: Terminal Kullanımı', 'file' => 'siber/html/modul3-terminal.html', 'order' => 3],
            ['title' => 'Modül 4: Kali Linux Kurulum', 'file' => 'siber/html/modul4-kali-kurulum.html', 'order' => 4],
            ['title' => 'Modül 5: Ağ Tarama', 'file' => 'siber/html/modul5-ag-tarama.html', 'order' => 5],
            ['title' => 'Modül 6: WiFi Penetration Testing', 'file' => 'siber/html/modul6-wifi-pentest.html', 'order' => 6],
            ['title' => 'Modül 7: Ethical Hacking', 'file' => 'siber/html/modul7-ethical-hacking.html', 'order' => 7],
            ['title' => 'Modül 8: OverTheWire Bandit (Level 0-10)', 'file' => 'siber/html/modul8-bandit.html', 'order' => 8],
        ];

        foreach ($siberNotlar as $not) {
            StudyNote::create([
                'category_id' => $siber->id,
                'title' => $not['title'],
                'slug' => pathinfo($not['file'], PATHINFO_FILENAME),
                'description' => null,
                'file_path' => 'notes/' . $not['file'],
                'type' => 'html',
                'order' => $not['order'],
                'is_active' => true,
            ]);
        }

        // Bilgisayar Mimarisi notları
        $mimariNotlar = [
            ['title' => 'Modül 1: Giriş', 'file' => 'bilgisayar mimarisi/html/modul1-giris.html', 'order' => 1],
            ['title' => 'Modül 2: RISC Mimarisi', 'file' => 'bilgisayar mimarisi/html/modul2-risc.html', 'order' => 2],
            ['title' => 'Modül 3: Giriş/Çıkış Sistemleri', 'file' => 'bilgisayar mimarisi/html/modul3-io.html', 'order' => 3],
            ['title' => 'Modül 4: Bellek Hiyerarşisi', 'file' => 'bilgisayar mimarisi/html/modul4-bellek.html', 'order' => 4],
            ['title' => 'Modül 5: Cache Bellek', 'file' => 'bilgisayar mimarisi/html/modul5-cache.html', 'order' => 5],
            ['title' => 'Modül 6: İleri Düzey Cache', 'file' => 'bilgisayar mimarisi/html/modul6-cache-ileri.html', 'order' => 6],
            ['title' => 'Modül 7: Cache Performans Analizi', 'file' => 'bilgisayar mimarisi/html/modul7-cache-performans.html', 'order' => 7],
        ];

        foreach ($mimariNotlar as $not) {
            StudyNote::create([
                'category_id' => $mimari->id,
                'title' => $not['title'],
                'slug' => pathinfo($not['file'], PATHINFO_FILENAME),
                'description' => null,
                'file_path' => 'notes/' . $not['file'],
                'type' => 'html',
                'order' => $not['order'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Çalışma notları başarıyla eklendi!');
    }
}
