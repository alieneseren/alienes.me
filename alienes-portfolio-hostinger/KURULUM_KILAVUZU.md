# 🚀 Alienes.me Portfolio - Kurulum Kılavuzu

## 📋 İçindekiler
1. [Sistem Gereksinimleri](#sistem-gereksinimleri)
2. [Hızlı Kurulum](#hızlı-kurulum)
3. [Detaylı Kurulum](#detaylı-kurulum)
4. [Yapılandırma](#yapılandırma)
5. [Kullanım](#kullanım)
6. [Sorun Giderme](#sorun-giderme)

## 🔧 Sistem Gereksinimleri

### Zorunlu
- PHP >= 8.1
- Composer
- SQLite, MySQL veya PostgreSQL
- Node.js >= 16.x
- NPM veya Yarn

### Önerilen
- PHP 8.2 veya üzeri
- 512MB RAM (minimum)
- Nginx veya Apache web sunucusu

## ⚡ Hızlı Kurulum

### Otomatik Kurulum (Önerilen)
```bash
# Repoyu klonlayın veya dosyaları indirin
cd alienes.me

# Otomatik kurulum scriptini çalıştırın
./install.sh
```

Script şunları yapacaktır:
- ✅ Composer bağımlılıklarını yükler
- ✅ .env dosyasını oluşturur
- ✅ Uygulama anahtarını üretir
- ✅ Veritabanını kurar
- ✅ Örnek verileri ekler
- ✅ Storage linkini oluşturur
- ✅ NPM bağımlılıklarını yükler
- ✅ Asset'leri derler

### Manuel Kurulum
```bash
# 1. Bağımlılıkları yükle
composer install

# 2. Ortam dosyasını yapılandır
cp .env.example .env
php artisan key:generate

# 3. Veritabanını hazırla
touch database/database.sqlite
php artisan migrate --seed

# 4. Storage linkini oluştur
php artisan storage:link

# 5. Frontend asset'lerini derle
npm install
npm run build

# 6. Sunucuyu başlat
php artisan serve
```

## 📝 Detaylı Kurulum

### 1. Projeyi Hazırlama

#### a) Git ile klonlama
```bash
git clone https://github.com/yourusername/alienes.me.git
cd alienes.me
```

#### b) Veya ZIP indirme
1. Projeyi ZIP olarak indirin
2. İstediğiniz klasöre çıkartın
3. Terminal'de proje klasörüne gidin

### 2. Backend Kurulumu

#### Composer Bağımlılıkları
```bash
composer install --optimize-autoloader --no-dev
```

**Composer yoksa:**
```bash
# macOS/Linux
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Windows
# https://getcomposer.org/Composer-Setup.exe adresinden indirin
```

#### Ortam Yapılandırması
```bash
cp .env.example .env
```

`.env` dosyasını düzenleyin:
```env
APP_NAME="Alienes Portfolio"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://alienes.me

DB_CONNECTION=sqlite
# SQLite için: database/database.sqlite dosyası kullanılacak
```

#### Uygulama Anahtarı
```bash
php artisan key:generate
```

#### Veritabanı Kurulumu

**SQLite (Önerilen - Kolay kurulum):**
```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

**MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alienes_portfolio
DB_USERNAME=root
DB_PASSWORD=your_password
```

```bash
mysql -u root -p
CREATE DATABASE alienes_portfolio;
exit;

php artisan migrate
php artisan db:seed
```

### 3. Frontend Kurulumu

#### Node.js ve NPM
```bash
# Node.js versiyonunu kontrol edin
node -v  # v16 veya üzeri olmalı

# NPM ile bağımlılıkları yükleyin
npm install

# Production için build
npm run build

# Development için (otomatik yenileme)
npm run dev
```

### 4. Dosya İzinleri

#### Linux/macOS
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Windows
- Özel bir işlem gerekmez

### 5. Storage Linki
```bash
php artisan storage:link
```

Bu komut `public/storage` -> `storage/app/public` symbolic link oluşturur.

## ⚙️ Yapılandırma

### Admin Hesabı

**Varsayılan giriş bilgileri:**
- **Email:** admin@alienes.me
- **Şifre:** password

⚠️ **ÖNEMLİ:** İlk girişten sonra şifrenizi mutlaka değiştirin!

### Profil Fotoğrafı

1. Admin paneline giriş yapın
2. "Profil" menüsüne tıklayın
3. "Profil Fotoğrafı" alanından resim yükleyin
4. Kaydet butonuna tıklayın

Desteklenen formatlar: JPG, PNG, GIF (Max 2MB)

### E-posta Yapılandırması

`.env` dosyasında mail ayarlarını yapın:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Production Deployment

#### 1. Optimizasyon
```bash
# Config cache
php artisan config:cache

# Route cache
php artisan route:cache

# View cache
php artisan view:cache

# Composer optimizasyonu
composer install --optimize-autoloader --no-dev
```

#### 2. Web Sunucusu

**Nginx Örnek Yapılandırma:**
```nginx
server {
    listen 80;
    server_name alienes.me www.alienes.me;
    root /var/www/alienes.me/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Apache .htaccess:**
- Proje zaten `.htaccess` dosyası ile birlikte gelir
- `mod_rewrite` modülünün aktif olduğundan emin olun

#### 3. SSL Sertifikası (Let's Encrypt)
```bash
sudo certbot --nginx -d alienes.me -d www.alienes.me
```

## 🎯 Kullanım

### Geliştirme Sunucusu
```bash
php artisan serve
```
Site: http://localhost:8000

### Admin Panel

**Giriş:** http://localhost:8000/admin/login

**Özellikler:**
- 📊 Dashboard - İstatistikler ve özet
- 👤 Profil - Kişisel bilgiler ve sosyal medya
- 💼 Deneyimler - İş geçmişi yönetimi
- 🎓 Eğitim - Eğitim geçmişi
- 🛠️ Yetenekler - Teknik beceriler (kategori ve seviye)
- 📁 Projeler - Portfolio projeleri (resim, link, teknolojiler)
- 📧 Mesajlar - İletişim formundan gelen mesajlar

### Frontend

**Ana Sayfa:** http://localhost:8000
- Hero bölümü (profil fotoğrafı ve tanıtım)
- Hakkımda
- Deneyimler
- Eğitim
- Yetenekler
- Öne çıkan projeler
- İletişim CTA

**Projeler:** http://localhost:8000/projects
- Tüm projeler grid görünümü
- Sayfalama
- Teknoloji etiketleri

**İletişim:** http://localhost:8000/contact
- İletişim formu
- İletişim bilgileri

### Dark Mode
- Otomatik sistem teması algılama
- Manuel toggle (navbar'da)
- Tercih localStorage'a kaydedilir

## 🐛 Sorun Giderme

### "Class not found" Hatası
```bash
composer dump-autoload
php artisan clear-compiled
php artisan cache:clear
```

### "No application encryption key" Hatası
```bash
php artisan key:generate
```

### Storage/Cache İzin Hataları
```bash
# Linux/macOS
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Veya tüm kullanıcılara izin ver (development için)
chmod -R 777 storage bootstrap/cache
```

### NPM Build Hataları
```bash
# Node modules'u temizle ve yeniden yükle
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Veritabanı Bağlantı Hatası
```bash
# SQLite dosyası var mı kontrol edin
ls -la database/database.sqlite

# Yoksa oluşturun
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### Composer Memory Limit
```bash
php -d memory_limit=-1 /usr/local/bin/composer install
```

### Sayfa 404 Hatası
- `.htaccess` dosyasının `public` klasöründe olduğundan emin olun
- Apache `mod_rewrite` modülünü aktifleştirin:
  ```bash
  sudo a2enmod rewrite
  sudo service apache2 restart
  ```

### CSS/JS Yüklenmiyor
```bash
npm run build
php artisan storage:link
```

## 📚 Ek Kaynaklar

### Yararlı Komutlar
```bash
# Cache temizleme
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Veritabanını sıfırlama
php artisan migrate:fresh --seed

# Production optimizasyonu
php artisan optimize

# Queue işleri (eğer kullanıyorsanız)
php artisan queue:work
```

### Log Dosyaları
```bash
# Laravel logları
tail -f storage/logs/laravel.log

# Nginx logları
tail -f /var/log/nginx/error.log
```

## 🆘 Destek

Sorun yaşıyorsanız:
1. Bu kılavuzu tekrar okuyun
2. `storage/logs/laravel.log` dosyasını kontrol edin
3. GitHub Issues'da arayın
4. Yeni bir issue açın

## 📄 Lisans

MIT License - Özgürce kullanabilirsiniz!

---

**İyi çalışmalar! 🚀**
