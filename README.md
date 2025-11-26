# Alienes.me - Profesyonel Portfolyo Sitesi

Modern ve dinamik bir portfolyo web sitesi. Laravel framework ile geliştirilmiştir.

## Özellikler

- 🎨 Modern ve responsive tasarım
- 🌙 Dark/Light mode desteği
- 👤 Profil yönetimi
- 💼 Deneyim yönetimi
- 🎓 Eğitim geçmişi
- 🛠️ Yetenekler (Skills)
- 📁 Proje portfolyosu
- 📧 İletişim formu
- 🔐 Admin paneli
- 📸 Resim yükleme sistemi

## Kurulum

### Gereksinimler
- PHP >= 8.1
- Composer
- Node.js & NPM
- SQLite (veya MySQL/PostgreSQL)

### Adımlar

1. Bağımlılıkları yükleyin:
```bash
composer install
npm install
```

2. Ortam değişkenlerini yapılandırın:
```bash
cp .env.example .env
php artisan key:generate
```

3. Veritabanını oluşturun:
```bash
touch database/database.sqlite
php artisan migrate --seed
```

4. Storage linkini oluşturun:
```bash
php artisan storage:link
```

5. Asset'leri derleyin:
```bash
npm run build
```

6. Geliştirme sunucusunu başlatın:
```bash
php artisan serve
```

## Varsayılan Admin Bilgileri

- **Email:** admin@alienes.me
- **Şifre:** password

⚠️ İlk girişten sonra şifrenizi değiştirmeyi unutmayın!

## Kullanım

### Frontend
Ana site: `http://localhost:8000`

### Admin Paneli
Admin girişi: `http://localhost:8000/admin/login`

Admin panelinden şunları yönetebilirsiniz:
- Profil bilgileri (isim, başlık, bio, sosyal medya linkleri)
- Deneyimler (şirket, pozisyon, tarih, açıklama)
- Eğitim (okul, bölüm, derece, tarih)
- Yetenekler (skill adı ve seviyesi)
- Projeler (başlık, açıklama, teknolojiler, görseller, linkler)
- İletişim mesajları

## Proje Yapısı

```
alienes.me/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Frontend/       # Public site controllers
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── public/
│   ├── images/             # Public images
│   └── uploads/            # User uploaded files
├── resources/
│   ├── views/
│   │   ├── admin/          # Admin panel views
│   │   ├── frontend/       # Public site views
│   │   └── layouts/        # Layout templates
│   └── js/                 # JavaScript files
└── routes/
    └── web.php             # Web routes
```

## Teknolojiler

- **Backend:** Laravel 10
- **Frontend:** Tailwind CSS, Alpine.js
- **Database:** SQLite (varsayılan)
- **Build Tool:** Vite

## Lisans

MIT License

## İletişim

Web: [alienes.me](https://alienes.me)
