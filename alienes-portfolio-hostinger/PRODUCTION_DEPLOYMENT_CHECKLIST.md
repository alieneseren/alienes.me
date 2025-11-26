# Production Deployment Kontrol Listesi

## ✅ TAMAMLANAN İŞLEMLER

### 1. Environment Ayarları
- ✅ `APP_ENV=production` olarak ayarlandı
- ✅ `APP_DEBUG=false` olarak ayarlandı
- ✅ `APP_URL=https://alienes.me` olarak ayarlandı

### 2. Güvenlik
- ✅ SecurityHeadersMiddleware oluşturuldu ve aktif edildi
- ✅ .htaccess dosyası güvenlik ayarlarıyla güncellendi
- ✅ CSRF koruması aktif
- ✅ Rate limiting ayarlandı (10 istek/60 saniye)
- ✅ Email validation güvenlik açığı kapatıldı

### 3. Email Sistemi
- ✅ NewContactMessage notification sınıfı oluşturuldu
- ✅ ContactController'a email gönderme eklendi
- ✅ .env'de email ayarları için template hazırlandı

### 4. Deployment Araçları
- ✅ deploy.sh scripti oluşturuldu
- ✅ .htaccess production ayarlarıyla güncellendi

## ⚠️ YAPMANIZ GEREKENLER (Hosting'e Yüklemeden Önce)

### 1. Database Ayarları
`.env` dosyasında MySQL ayarlarını yapın:

```env
# Şu satırları yorumdan çıkarın ve bilgilerinizle doldurun:
DB_CONNECTION=mysql
DB_HOST=localhost (veya hosting'in verdiği host)
DB_PORT=3306
DB_DATABASE=alienes_portfolio (veya kendi database adınız)
DB_USERNAME=root (veya hosting'in verdiği username)
DB_PASSWORD=your_db_password (hosting'in verdiği password)
```

### 2. Email Ayarları
`.env` dosyasında mail ayarlarını yapın:

**Gmail için:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Alienes Portfolio"
```

**Not:** Gmail kullanıyorsanız, Google hesabınızda "App Password" oluşturmanız gerekir:
1. Google hesabınıza gidin
2. Security → 2-Step Verification'ı aktif edin
3. App passwords → Select app: Mail → Generate
4. Oluşan şifreyi MAIL_PASSWORD'e yazın

**Hosting mail server için (cPanel/Plesk):**
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.alienes.me (hosting mail server'ı)
MAIL_PORT=465
MAIL_USERNAME=noreply@alienes.me
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@alienes.me
MAIL_FROM_NAME="Alienes Portfolio"
```

### 3. SSL Sertifikası Kurulduktan Sonra
`public/.htaccess` dosyasında şu satırların yorumunu kaldırın:

```apache
# Force HTTPS (SSL)
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

## 🚀 DEPLOYMENT ADIMLARI

### Hosting'e İlk Yükleme:

1. **Dosyaları Yükleyin**
   - Tüm projeyi hosting'e yükleyin (FTP/SFTP/Git)
   - `public` klasörünün içeriğini `public_html` veya `www` klasörüne taşıyın
   - Geri kalan dosyalar `public_html`'in dışında olmalı

2. **Composer Bağımlılıklarını Yükleyin**
   ```bash
   cd /path/to/project
   composer install --no-dev --optimize-autoloader
   ```

3. **NPM Build**
   ```bash
   npm install
   npm run build
   ```

4. **Dosya İzinleri**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chmod 600 .env
   ```

5. **Database Migration**
   ```bash
   php artisan migrate --force
   ```

6. **Cache Oluştur**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

7. **Admin Kullanıcısı Oluşturun**
   ```bash
   php artisan tinker
   ```
   Sonra:
   ```php
   $user = new App\Models\User();
   $user->name = 'Admin';
   $user->email = 'admin@alienes.me';
   $user->password = bcrypt('güçlü-şifreniz');
   $user->save();
   ```

### Sonraki Güncellemeler İçin:

Deploy script'ini kullanın:
```bash
./deploy.sh
```

## 🧪 TEST ADIMlari

1. ✅ Ana sayfayı açın ve kontrol edin
2. ✅ Contact form'u doldurup gönder
3. ✅ Admin e-postasına email geldiğini kontrol edin
4. ✅ Admin panele giriş yapın: `https://alienes.me/admin/login`
5. ✅ Mesajlar sekmesinde gönderilen mesajı görün
6. ✅ Sosyal medya linklerini test edin
7. ✅ Dark mode'u test edin
8. ✅ Mobile görünümü test edin

## 📧 EMAIL TEST

Contact form'dan mesaj gönderdikten sonra:
- ✅ Admin panelde mesaj görünmeli
- ✅ Profilde ayarlanan email adresine notification gelmeli
- ✅ Email gelmiyorsa `storage/logs/laravel.log` kontrol edin

## 🔒 GÜVENLİK KONTROL LİSTESİ

- ✅ APP_DEBUG=false
- ✅ APP_ENV=production
- ✅ .env dosyası korumalı (600 izni)
- ✅ storage/ klasörü yazılabilir (755)
- ✅ SSL sertifikası kuruldu (Let's Encrypt önerilir)
- ✅ HTTPS yönlendirmesi aktif
- ✅ Security headers eklendi
- ✅ CSRF koruması aktif
- ✅ Rate limiting aktif
- ✅ SQL injection koruması (Eloquent ORM)

## 🐛 SORUN GİDERME

### Beyaz Sayfa (500 Error)
```bash
php artisan cache:clear
chmod -R 755 storage bootstrap/cache
```

### Email Gönderilmiyor
- MAIL_* ayarlarını kontrol edin
- `storage/logs/laravel.log` dosyasını kontrol edin
- Gmail kullanıyorsanız App Password oluşturdunuz mu?

### CSS/JS Yüklenmiyor
```bash
npm run build
php artisan view:clear
```

### Database Bağlantı Hatası
- DB_* ayarlarını kontrol edin
- Hosting'den database bilgilerini doğru aldınız mı?
- Database kullanıcısı oluşturuldu mu?

## 📝 NOTLAR

- Admin panele ilk giriş: `https://alienes.me/admin/login`
- Loglar: `storage/logs/laravel.log`
- Queue kullanmıyorsanız email anında gönderilir
- GitHub senkronizasyonu için GITHUB_TOKEN eklemeyi unutmayın

## 🎉 BAŞARIYLA TAMAMLANDIKTAN SONRA

1. Admin panele giriş yapın
2. Profil bilgilerinizi güncelleyin
3. Sosyal medya linklerini ekleyin
4. GitHub senkronizasyonunu yapın (opsiyonel)
5. CV/Resume linkinizi ekleyin
6. Test mesajı gönderin

Herhangi bir sorun yaşarsanız `storage/logs/laravel.log` dosyasını kontrol edin!

