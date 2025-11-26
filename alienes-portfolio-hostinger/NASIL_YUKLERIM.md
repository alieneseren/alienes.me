# 🎯 Production'a Yükleme - Hızlı Kılavuz

## ⚡ Hızlı Özet

Projeniz production'a yüklemeye **HAZIR**! Aşağıdaki adımları takip edin:

### 1️⃣ Hosting'de Yapılacaklar

```bash
# 1. Projeyi klonlayın veya yükleyin
git clone your-repo-url
cd alienes.me

# 2. .env dosyasını düzenleyin
cp .env.example .env
nano .env

# Şu değerleri değiştirin:
# - APP_ENV=production
# - APP_DEBUG=false
# - APP_URL=https://alienes.me
# - DB_* (MySQL bilgileri)
# - MAIL_* (Email bilgileri)

# 3. Bağımlılıkları yükleyin
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 4. Key generate edin
php artisan key:generate

# 5. Database kurulumu
php artisan migrate --force

# 6. Admin kullanıcısı
php artisan tinker
>>> $user = new App\Models\User();
>>> $user->name = 'Admin';
>>> $user->email = 'admin@alienes.me';
>>> $user->password = bcrypt('güçlü_şifreniz');
>>> $user->save();
>>> exit

# 7. İzinler
chmod -R 755 storage bootstrap/cache
chmod 600 .env

# 8. Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. SSL kurulduktan sonra
# public/.htaccess'te HTTPS yönlendirmeyi aktif edin
```

### 2️⃣ .env Dosyası Örneği

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://alienes.me

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=alienes_portfolio
DB_USERNAME=root
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
```

### 3️⃣ Gmail App Password Nasıl Alınır?

1. Google Account → Security
2. 2-Step Verification'ı aktif et
3. App passwords → Mail seç
4. Generate butonuna tıkla
5. Oluşan 16 haneli şifreyi kopyala
6. .env'de MAIL_PASSWORD'e yapıştır

### 4️⃣ Sonraki Güncellemeler

```bash
./deploy.sh
```

## 📋 Yapılanlar Listesi

✅ Production environment ayarları
✅ Güvenlik middleware'leri
✅ .htaccess güvenlik ayarları
✅ Email notification sistemi
✅ Rate limiting
✅ SQL injection koruması
✅ XSS koruması
✅ CSRF koruması
✅ Security headers
✅ Deploy scripti

## 🎯 Test Checklist

- [ ] Ana sayfa açılıyor
- [ ] Admin panele giriş yapabiliyorum
- [ ] Contact form mesaj gönderiyor
- [ ] Admin email'e bildirim geliyor
- [ ] Sosyal medya linkleri çalışıyor
- [ ] Dark mode çalışıyor
- [ ] Mobile görünüm düzgün

## 📞 İletişim Bilgileri

- Admin Panel: `https://alienes.me/admin/login`
- Loglar: `storage/logs/laravel.log`

## 🆘 Sorun mu var?

1. `PRODUCTION_DEPLOYMENT_CHECKLIST.md` dosyasına bakın
2. `storage/logs/laravel.log` kontrol edin
3. Cache temizleyin: `php artisan cache:clear`

---

**HAZIR! Hosting'e yükleyebilirsiniz! 🚀**
