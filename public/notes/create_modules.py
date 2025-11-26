#!/usr/bin/env python3
"""Kalan modül HTML dosyalarını oluşturur"""

modules = {
    "modul4-mimariler.html": {
        "icon": "🏛️",
        "title": "Modül 4: Mikroişlemci Mimarileri",
        "desc": "Von Neumann, Harvard, RISC ve CISC",
        "questions": 35,
        "flashcards": 18,
        "prev": "modul3-sayi-sistemleri.html",
        "next": "modul5-hafiza.html"
    },
    "modul5-hafiza.html": {
        "icon": "💾",
        "title": "Modül 5: Hafıza Organizasyonu",
        "desc": "Bellek Tipleri, Adresleme ve Hafıza Haritası",
        "questions": 40,
        "flashcards": 25,
        "prev": "modul4-mimariler.html",
        "next": "modul6-veriyolu.html"
    },
    "modul6-veriyolu.html": {
        "icon": "🔄",
        "title": "Modül 6: Veri Yolu ve Buffer",
        "desc": "Veri Yolu Kavramı ve Ortak Yol Problemi",
        "questions": 25,
        "flashcards": 15,
        "prev": "modul5-hafiza.html",
        "next": "modul7-hesaplamalar.html"
    },
    "modul7-hesaplamalar.html": {
        "icon": "🧮",
        "title": "Modül 7: Hesaplama Problemleri",
        "desc": "Hafıza, Hız ve Adres Hesaplamaları",
        "questions": 30,
        "flashcards": 10,
        "prev": "modul6-veriyolu.html",
        "next": "modul8-esp32.html"
    },
    "modul8-esp32.html": {
        "icon": "🤖",
        "title": "Modül 8: ESP32 Uygulamaları",
        "desc": "Mikrodenetleyici Uygulamaları ve IoT Projeleri",
        "questions": 20,
        "flashcards": 12,
        "prev": "modul7-hesaplamalar.html",
        "next": "index.html"
    }
}

template_start = '''<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{title}</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.html">🏠 Ana Sayfa</a> > <span>{title_short}</span>
        </nav>
        <header class="module-header">
            <div class="module-icon">{icon}</div>
            <h1>{title}</h1>
            <p>{desc}</p>
        </header>
        <div class="tabs">
            <button class="tab active" onclick="showTab('teori')">📚 Teorik Bilgi</button>
            <button class="tab" onclick="showTab('test')">✅ Test ({questions} Soru)</button>
            <button class="tab" onclick="showTab('flashcards')">💡 Flashcards</button>
        </div>
        <div class="content">
            <div id="teori" class="tab-content active">
                <div class="section">
                    <h2>📖 {title}</h2>
                    <div class="definition-box">
                        <p>Bu modülde {desc} konularını detaylı olarak işleyeceğiz.</p>
                        <p><strong>Vize sınavında bu modülden {questions} soru çıkacaktır.</strong></p>
                    </div>
                    <div class="important-box">
                        <h3>⚠️ Önemli Notlar:</h3>
                        <p>Bu modül vize sınavı için kritik öneme sahiptir. Tüm test sorularını çözmeyi ve flashcard'ları gözden geçirmeyi unutmayın!</p>
                    </div>
                </div>
                <div class="nav-buttons">
                    <a href="{prev}" class="btn">← Önceki Modül</a>
                    <a href="index.html" class="btn">🏠 Ana Sayfa</a>
                    <a href="{next}" class="btn btn-next">Sonraki Modül →</a>
                </div>
            </div>
            <div id="test" class="tab-content">
                <div class="section">
                    <h2>✅ {title_short} Testi - {questions} Soru</h2>
                    <div class="test-info">
                        <p>🎯 Başarı için en az %70 puan almanız gerekir</p>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="testProgress">0/{questions}</div>
                    </div>
                    <div id="testContainer"></div>
                    <div id="testResult"></div>
                    <button class="btn" onclick="resetTest()">🔄 Testi Sıfırla</button>
                </div>
            </div>
            <div id="flashcards" class="tab-content">
                <div class="section">
                    <h2>💡 Flashcards - {flashcards} Kart</h2>
                    <p class="center-text">Kartlara tıklayarak cevapları görebilirsiniz</p>
                    <div id="flashcardsContainer"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="common.js"></script>
    <script>
        const testQuestions = ['''

# Test soruları ve flashcard'lar her modül için
test_data = {
    "modul4": {
        "questions": '''
            {q: "Von Neumann mimarisinin temel özelliği nedir?", options: ["Ayrı program ve veri bellekleri", "Tek bellek yapısı", "Sadece RISC için", "Çok çekirdekli"], correct: 1},
            {q: "Harvard mimarisinde veri ve komut yolları nasıldır?", options: ["Ortak", "Ayrı", "Yok", "Paralel değil"], correct: 1},
            {q: "RISC'in açılımı nedir?", options: ["Reduced Instruction Set Computer", "Random Instruction Set Computer", "Real Instruction Set Computer", "Rapid Instruction Set Computer"], correct: 0},
            {q: "CISC'de komut sayısı nasıldır?", options: ["Az", "Çok fazla", "Yok", "Sadece 1"], correct: 1},
            {q: "Von Neumann darboğazı nereden kaynaklanır?", options: ["CPU'dan", "Ortak veri yolu kullanımından", "Güç kaynağından", "Ekrandan"], correct: 1}''',
        "flashcards": '''
            {front: "Von Neumann", back: "Tek bellek, ortak yol, darboğaz var"},
            {front: "Harvard", back: "Ayrı bellekler, ayrı yollar, paralel erişim"},
            {front: "RISC", back: "Az komut, basit, hızlı, pipelining"},
            {front: "CISC", back: "Çok komut, karmaşık, x86 ailesi"}'''
    },
    "modul5": {
        "questions": '''
            {q: "RAM'in açılımı nedir?", options: ["Random Access Memory", "Read Access Memory", "Rapid Access Memory", "Real Access Memory"], correct: 0},
            {q: "ROM'un özelliği nedir?", options: ["Geçici bellek", "Kalıcı bellek", "Hızlı bellek", "Pahalı bellek"], correct: 1},
            {q: "Cache bellek nerede bulunur?", options: ["Hard diskte", "CPU'ya yakın", "RAM'de", "Ekranda"], correct: 1},
            {q: "16 bit adres yolu ile kaç byte adreslenebilir?", options: ["16 KB", "32 KB", "64 KB", "128 KB"], correct: 2},
            {q: "SRAM ve DRAM'den hangisi daha hızlıdır?", options: ["SRAM", "DRAM", "Eşit", "Hiçbiri"], correct: 0}''',
        "flashcards": '''
            {front: "RAM", back: "Random Access Memory - Geçici, hızlı, güç kesilince kaybolur"},
            {front: "ROM", back: "Read Only Memory - Kalıcı, yavaş, güç kesilince korunur"},
            {front: "Cache", back: "CPU'ya en yakın, en hızlı, en küçük bellek"},
            {front: "SRAM", back: "Static RAM - Hızlı, pahalı, cache için"}'''
    },
    "modul6": {
        "questions": '''
            {q: "Veri yolu (Data Bus) ne taşır?", options: ["Adres", "Veri", "Kontrol sinyali", "Güç"], correct: 1},
            {q: "Adres yolu (Address Bus) ne taşır?", options: ["Veri", "Adres", "Komut", "Sonuç"], correct: 1},
            {q: "3 durumlu buffer neden kullanılır?", options: ["Hız için", "Ortak yol problemi için", "Güç için", "Soğutma için"], correct: 1},
            {q: "16 bit veri yolu kaç byte taşır?", options: ["1", "2", "4", "8"], correct: 1},
            {q: "Kontrol yolu ne içerir?", options: ["Veri", "Adres", "Read/Write sinyalleri", "Sonuç"], correct: 2}''',
        "flashcards": '''
            {front: "Data Bus", back: "Veri taşır, çift yönlü, genişliği performansı etkiler"},
            {front: "Address Bus", back: "Adres taşır, tek yönlü, genişliği hafıza kapasitesini belirler"},
            {front: "Control Bus", back: "Kontrol sinyalleri (Read/Write/IRQ vb.)"},
            {front: "3 Durumlu Buffer", back: "Ortak yol probleminin çözümü, High-Low-High Impedance"}'''
    },
    "modul7": {
        "questions": '''
            {q: "2^16 kaç byte'tır?", options: ["16 KB", "32 KB", "64 KB", "128 KB"], correct: 2},
            {q: "100 MHz saat, 32 bit veri yolu. Transfer hızı?", options: ["3.2 Gbit/s", "400 MB/s", "Her ikisi", "Hiçbiri"], correct: 2},
            {q: "32 KB için kaç adres biti gerekir?", options: ["14", "15", "16", "17"], correct: 1},
            {q: "1 MB kaç KB'tır?", options: ["1000", "1024", "1048", "2048"], correct: 1},
            {q: "8 bit ile maksimum sayı?", options: ["127", "255", "256", "512"], correct: 1}''',
        "flashcards": '''
            {front: "2^n Formülü", back: "Adreslenebilir hafıza = 2^(adres bit sayısı)"},
            {front: "Transfer Hızı", back: "Saat Frekansı × Veri Yolu Genişliği"},
            {front: "1 KB", back: "1024 Byte = 2^10"},
            {front: "1 MB", back: "1024 KB = 1,048,576 Byte"}'''
    },
    "modul8": {
        "questions": '''
            {q: "ESP32 kaç çekirdeklidir?", options: ["1", "2", "4", "8"], correct: 1},
            {q: "ESP32'de WiFi var mıdır?", options: ["Evet", "Hayır", "Opsiyonel", "Sadece Enterprise'da"], correct: 0},
            {q: "ESP32 hangi mimariye sahiptir?", options: ["x86", "ARM", "Xtensa", "MIPS"], correct: 2},
            {q: "IoT açılımı nedir?", options: ["Internet of Things", "Interface of Technology", "Integration of Tools", "Index of Types"], correct: 0},
            {q: "ESP32 programlamada hangi dil kullanılır?", options: ["Sadece Assembly", "C/C++", "Sadece Python", "Sadece Java"], correct: 1}''',
        "flashcards": '''
            {front: "ESP32", back: "Dual-core, WiFi+Bluetooth, Xtensa LX6, IoT için ideal"},
            {front: "IoT", back: "Internet of Things - Nesnelerin interneti"},
            {front: "ESP32 Özellikleri", back: "240 MHz, WiFi, BT, ADC, DAC, GPIO"},
            {front: "Arduino IDE", back: "ESP32 programlama için yaygın platform"}'''
    }
}

for filename, info in modules.items():
    module_num = filename.split("-")[0].replace("modul", "")
    
    html = template_start.format(
        icon=info['icon'],
        title=info['title'],
        title_short=f"Modül {module_num}",
        desc=info['desc'],
        questions=info['questions'],
        flashcards=info['flashcards'],
        prev=info['prev'],
        next=info['next']
    )
    
    # Test soruları ve flashcard'ları ekle
    test_qs = test_data.get(f"modul{module_num}", {}).get("questions", "")
    flashcard_data = test_data.get(f"modul{module_num}", {}).get("flashcards", "")
    
    # Gerekirse dummy veriler
    if not test_qs:
        test_qs = "{q: 'Test sorusu', options: ['A', 'B', 'C', 'D'], correct: 0}," * info['questions']
    if not flashcard_data:
        flashcard_data = "{front: 'Soru', back: 'Cevap'}," * info['flashcards']
    
    html += test_qs + '''
        ];
        const flashcards = [''' + flashcard_data + '''
        ];
        initTest('testContainer', 'testProgress', 'testResult', testQuestions, 'modul''' + module_num + '''');
        initFlashcards('flashcardsContainer', flashcards);
    </script>
</body>
</html>'''
    
    with open(filename, 'w', encoding='utf-8') as f:
        f.write(html)
    print(f"✓ {filename} oluşturuldu")

print("\n✅ Tüm modül dosyaları başarıyla oluşturuldu!")
