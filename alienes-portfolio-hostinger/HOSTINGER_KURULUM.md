# 🚀 Hostinger'a Yükleme Kılavuzu

## 📦 Hazırlık (Bilgisayarınızda)

### 1. Projeyi Ziplemeden Önce

```bash
# Terminal'de proje klasörüne gidin
cd /Users/alienes/alienes.me

# Vendor ve node_modules'ü silin (sunucuda yükleyeceğiz)
rm -rf vendor node_modules

# ZIP oluşturun
zip -r alienes-portfolio.zip . -x "*.git*" "*.DS_Store" "node_modules/*" "vendor/*"
```

## 🌐 Hostinger'da Yapılacaklar

### 2. Database Oluşturma

1. **Hostinger Panel'e** giriş yapın
2. **MySQL Databases** bölümüne gidin
3. **Create Database** butonuna tıklayın
4. Database bilgilerini kaydedin:
   ```
   Database Name: u123456789_portfolio
   Username: u123456789_user
   Password: (oluşturduğunuz şifre)
   Host: localhost
   ```

### 3. Email Ayarları

**Seçenek 1: Hostinger Email (Önerilen)**
1. **Email Accounts** bölümüne gidin
2. Yeni email oluşturun: `noreply@alienes.me`
3. Şifreyi kaydedin
4. SMTP ayarları:
   ```
   Host: smtp.hostinger.com
   Port: 465
   Encryption: SSL
   ```

**Seçenek 2: Gmail**
1. Gmail hesabınızda 2-Step Verification açın
2. App Password oluşturun
3. Ayarlar:
   ```
   Host: smtp.gmail.com
   Port: 587
   Encryption: TLS
   ```

### 4. Dosya Yükleme

**File Manager ile:**

1. **File Manager**'ı açın
2. `domains/alienes.me` klasörüne gidin
3. `alienes-portfolio.zip` dosyasını yükleyin
4. **Extract** (Sıkıştırmayı Aç) butonuna tıklayın
5. ZIP dosyasını silin

**Veya FTP ile:**
```
Host: ftp.alienes.me
Username: (Hostinger'dan aldığınız)
Password: (Hostinger'dan aldığınız)
Port: 21
```

### 5. Dizin Yapısını Düzenleme

SSH'ye bağlanın ve şu komutları çalıştırın:

```bash
# SSH ile bağlanın
ssh u123456789@yourdomain.com

# Proje dizinine gidin
cd domains/alienes.me

# public_html içeriğini temizleyin
rm -rf public_html/*

# public klasörünün içindekileri public_html'e taşıyın
mv public/* public_html/
mv public/.htaccess public_html/

# Artık boş olan public klasörünü silin
rmdir public
```

### 6. .env Dosyasını Düzenleme

```bash
# .env dosyasını oluşturun
cp .env.hostinger .env

# Düzenleyin
nano .env
```

**Değiştirmeniz gerekenler:**

```env
APP_URL=https://alienes.me  # Kendi domain'iniz

# Database bilgileri (2. adımdan)
DB_DATABASE=u123456789_portfolio
DB_USERNAME=u123456789_user
DB_PASSWORD=veritabani_sifreniz

# Email bilgileri (3. adımdan)
MAIL_USERNAME=noreply@alienes.me
MAIL_PASSWORD=email_sifreniz
```

Kaydet: `CTRL+O`, Enter, Çıkış: `CTRL+X`

### 7. Kurulum Scriptini Çalıştırma

```bash
# Kurulum scriptini çalıştırın
chmod +x hostinger-setup.sh
./hostinger-setup.sh
```

Script sizden soracak:
- Admin Email: `admin@alienes.me`
- Admin Şifre: (güçlü bir şifre belirleyin)

### 8. Son Ayarlar

```bash
# Composer bağımlılıklarını yükleyin
composer install --no-dev --optimize-autoloader

# NPM build (eğer Node.js varsa)
npm install
npm run build

# Cache oluşturun
php artisan config:cache
php artisan route:cache
php artisan view:cache

# İzinleri ayarlayın
chmod -R 755 storage bootstrap/cache
chmod 600 .env
```

### 9. SSL/HTTPS Ayarları

1. **Hostinger Panel** → **SSL**
2. **Let's Encrypt** ile ücretsiz SSL kurun
3. SSL kurduktan sonra:

```bash
nano public_html/.htaccess
```

Şu satırların yorumunu kaldırın (başındaki # işaretlerini silin):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

## ✅ Test

1. **Ana sayfa:** `https://alienes.me`
2. **Admin panel:** `https://alienes.me/admin/login`
3. **Contact form** test edin
4. **Email geldiğini** kontrol edin

## 🐛 Sorun Giderme

### "500 Internal Server Error"

```bash
# Cache temizle
php artisan cache:clear
php artisan config:clear

# İzinleri kontrol et
chmod -R 755 storage bootstrap/cache
chmod 600 .env

# Log kontrol et
tail -50 storage/logs/laravel.log
```

### "Database connection failed"

```bash
# .env dosyasını kontrol et
nano .env

# Database bilgilerinin doğru olduğundan emin ol
# Sonra cache'i temizle
php artisan config:clear
```

### "Email gönderilmiyor"

```bash
# Email ayarlarını kontrol et
nano .env

# MAIL_* değerlerini kontrol et
# Cache temizle
php artisan config:clear

# Log'u kontrol et
tail -50 storage/logs/laravel.log
```

### "CSS/JS yüklenmiyor"

```bash
# Build'i yeniden çalıştır
npm run build

# Cache temizle
php artisan view:clear
```

## 📋 Önemli Dosya Yolları

```
/domains/alienes.me/              (Ana dizin)
├── public_html/                  (Web root - eski public/)
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── app/
├── config/
├── database/
├── resources/
├── storage/
├── .env
└── hostinger-setup.sh
```

## 🔐 Güvenlik Kontrol Listesi

- ✅ `.env` dosyası 600 izinli
- ✅ `storage/` ve `bootstrap/cache/` 755 izinli
- ✅ APP_DEBUG=false
- ✅ APP_ENV=production
- ✅ SSL kurulu
- ✅ HTTPS yönlendirme aktif
- ✅ Güçlü admin şifresi

## 📞 İletişim

- **Admin Panel:** https://alienes.me/admin/login
- **Loglar:** storage/logs/laravel.log
- **Hostinger Destek:** 24/7 Chat desteği

---

**Kurulum süresi:** ~10-15 dakika
**Gerekli bilgi:** Database ve Email bilgileri

🎉 **Başarılar!**
