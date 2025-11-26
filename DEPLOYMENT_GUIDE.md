# Çalışma Notları - Production Deployment Rehberi

## 📋 Yüklenecek Dosyalar

### 1️⃣ Database (Migration & Seeder)
```bash
# Migration
database/migrations/2025_11_02_145836_create_study_categories_and_notes_tables.php

# Seeder
database/seeders/StudyNotesSeeder.php
```

### 2️⃣ Models
```bash
app/Models/StudyCategory.php
app/Models/StudyNote.php
```

### 3️⃣ Controllers
```bash
# Frontend Controller
app/Http/Controllers/StudyController.php

# Admin Controllers
app/Http/Controllers/Admin/StudyCategoryController.php
app/Http/Controllers/Admin/StudyNoteController.php
```

### 4️⃣ Views
```bash
# Frontend Views
resources/views/study/index.blade.php
resources/views/study/category.blade.php
resources/views/study/show.blade.php

# Admin Views - Categories
resources/views/admin/study-categories/index.blade.php
resources/views/admin/study-categories/create.blade.php
resources/views/admin/study-categories/edit.blade.php

# Admin Views - Notes
resources/views/admin/study-notes/index.blade.php
resources/views/admin/study-notes/create.blade.php
resources/views/admin/study-notes/edit.blade.php
```

### 5️⃣ Routes
```bash
routes/web.php (güncellenmiş - study rotaları eklenmiş)
```

### 6️⃣ Layouts (Güncellenmiş)
```bash
resources/views/layouts/frontend.blade.php (navbar'a çalışma notları linki eklendi)
resources/views/layouts/admin.blade.php (sidebar'a çalışma notları linkleri eklendi)
```

### 7️⃣ Public Assets (HTML Dosyaları)
```bash
# Ana CSS ve JS dosyaları
public/notes/style.css
public/notes/common.js

# Mikroişlemciler (13 dosya)
public/notes/modul1-giris.html
public/notes/modul2-yariletken.html
public/notes/modul3-pic16f84a.html
public/notes/modul4-kesme-zamanlayici.html
public/notes/modul5-sayisal-display.html
public/notes/modul6-haberlesme.html
public/notes/modul7-adc.html
public/notes/modul8-pwm-motor.html
public/notes/formul-ozet.html
public/notes/pratik-sorular.html
public/notes/testler.html
public/notes/flashcards.html
public/notes/calisma-plani.html

# Otomata (8 dosya)
public/notes/otomata/modul1-giris.html
public/notes/otomata/modul2-duzenli-ifadeler.html
public/notes/otomata/modul3-duzenli-diller.html
public/notes/otomata/modul4-iceriksiz-gramerler.html
public/notes/otomata/formul-ozet.html
public/notes/otomata/pratik-sorular.html
public/notes/otomata/testler.html
public/notes/otomata/flashcards.html

# Evrimsel Hesaplama (7 dosya)
public/notes/evrimsel hesaplama/html/modul1-optimizasyon.html
public/notes/evrimsel hesaplama/html/modul2-pso.html
public/notes/evrimsel hesaplama/html/modul3-abc.html
public/notes/evrimsel hesaplama/html/modul4-genetik.html
public/notes/evrimsel hesaplama/html/modul5-diferansiyel.html
public/notes/evrimsel hesaplama/html/modul6-tavlama-tabu.html
public/notes/evrimsel hesaplama/html/modul7-karinca.html

# Siber Güvenlik (7 dosya)
public/notes/siber/html/modul1-bash.html
public/notes/siber/html/modul2-kali-komutlari.html
public/notes/siber/html/modul3-terminal.html
public/notes/siber/html/modul4-kali-kurulum.html
public/notes/siber/html/modul5-ag-tarama.html
public/notes/siber/html/modul6-wifi-pentest.html
public/notes/siber/html/modul7-ethical-hacking.html

# Bilgisayar Mimarisi (7 dosya)
public/notes/bilgisayar mimarisi/html/modul1-giris.html
public/notes/bilgisayar mimarisi/html/modul2-risc.html
public/notes/bilgisayar mimarisi/html/modul3-io-sistemleri.html
public/notes/bilgisayar mimarisi/html/modul4-bellek-hiyerarsisi.html
public/notes/bilgisayar mimarisi/html/modul5-cache-bellek.html
public/notes/bilgisayar mimarisi/html/modul6-ileri-cache.html
public/notes/bilgisayar mimarisi/html/modul7-cache-performans.html
```

## 🚀 Deployment Adımları

### Adım 1: SSH ile Bağlan
```bash
ssh -p 65002 u233064020@147.93.92.23
cd domains/alienes.me
```

### Adım 2: Migration Çalıştır
```bash
php artisan migrate
```

### Adım 3: Seeder Çalıştır (Çalışma Notlarını Ekle)
```bash
php artisan db:seed --class=StudyNotesSeeder
```

### Adım 4: Cache Temizle
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Adım 5: Optimize Et
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ✅ Test Et

### Frontend
- https://alienes.me/study
- https://alienes.me/study/mikroislemciler
- https://alienes.me/study/otomata
- https://alienes.me/study/evrimsel-hesaplama
- https://alienes.me/study/siber-guvenlik
- https://alienes.me/study/bilgisayar-mimarisi

### Admin Panel
- https://alienes.me/admin/study-categories
- https://alienes.me/admin/study-notes

## 📊 Beklenen Sonuçlar

- **5 Kategori**: Mikroişlemciler, Otomata, Evrimsel Hesaplama, Siber Güvenlik, Bilgisayar Mimarisi
- **42 Ders Notu**: Toplamda 42 HTML dosyası
- **Modern UI**: 3 sütunlu grid, gradient hover efektleri, dinamik iconlar
- **Dark Mode**: Tüm sayfalarda dark mode desteği
- **Admin CRUD**: Tam özellikli kategori ve not yönetimi

## 🔧 SCP Komutları (Alternatif)

### Migration & Seeder
```bash
scp -P 65002 database/migrations/2025_11_02_145836_create_study_categories_and_notes_tables.php u233064020@147.93.92.23:~/domains/alienes.me/database/migrations/

scp -P 65002 database/seeders/StudyNotesSeeder.php u233064020@147.93.92.23:~/domains/alienes.me/database/seeders/
```

### Models
```bash
scp -P 65002 app/Models/Study*.php u233064020@147.93.92.23:~/domains/alienes.me/app/Models/
```

### Controllers
```bash
scp -P 65002 app/Http/Controllers/StudyController.php u233064020@147.93.92.23:~/domains/alienes.me/app/Http/Controllers/

scp -P 65002 -r app/Http/Controllers/Admin/Study*.php u233064020@147.93.92.23:~/domains/alienes.me/app/Http/Controllers/Admin/
```

### Views (Klasörleri oluşturup toplu yükleme)
```bash
# Frontend views
scp -P 65002 -r resources/views/study u233064020@147.93.92.23:~/domains/alienes.me/resources/views/

# Admin views
scp -P 65002 -r resources/views/admin/study-categories u233064020@147.93.92.23:~/domains/alienes.me/resources/views/admin/

scp -P 65002 -r resources/views/admin/study-notes u233064020@147.93.92.23:~/domains/alienes.me/resources/views/admin/
```

### HTML Assets (En büyük transfer)
```bash
# Tüm notes klasörünü yükle
scp -P 65002 -r public/notes u233064020@147.93.92.23:~/domains/alienes.me/public/
```

### Layouts (Güncellenmiş)
```bash
scp -P 65002 resources/views/layouts/frontend.blade.php u233064020@147.93.92.23:~/domains/alienes.me/resources/views/layouts/

scp -P 65002 resources/views/layouts/admin.blade.php u233064020@147.93.92.23:~/domains/alienes.me/resources/views/layouts/
```

### Routes
```bash
scp -P 65002 routes/web.php u233064020@147.93.92.23:~/domains/alienes.me/routes/
```

## 📦 ZIP Paketi (File Manager için)

Eğer SSH sorun veriyorsa, tüm dosyaları zip'leyip Hostinger File Manager'dan yükleyebilirsin:

```bash
cd /Users/alienes/alienes.me
zip -r study_notes_deployment.zip \
  database/migrations/2025_11_02_145836_create_study_categories_and_notes_tables.php \
  database/seeders/StudyNotesSeeder.php \
  app/Models/StudyCategory.php \
  app/Models/StudyNote.php \
  app/Http/Controllers/StudyController.php \
  app/Http/Controllers/Admin/StudyCategoryController.php \
  app/Http/Controllers/Admin/StudyNoteController.php \
  resources/views/study \
  resources/views/admin/study-categories \
  resources/views/admin/study-notes \
  resources/views/layouts/frontend.blade.php \
  resources/views/layouts/admin.blade.php \
  routes/web.php \
  public/notes
```

Sonra Hostinger File Manager'a gir ve zip'i yükle, extract et.
