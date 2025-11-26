# 🎯 HOSTINGER'A YÜKLEME - HIZLI BAŞLANGIÇ

## 🚀 3 Adımda Yükleme

### 1️⃣ ZIP Oluştur (Bilgisayarınızda)

```bash
cd /Users/alienes/alienes.me
./create-hostinger-package.sh
```

Bu komut `alienes-portfolio-hostinger.zip` dosyasını oluşturacak.

### 2️⃣ Hostinger'da Hazırlık

#### A) Database Oluştur
1. Hostinger Panel → **MySQL Databases**
2. **Create Database** tıkla
3. Bilgileri kaydet:
   - Database: `u123456789_portfolio`
   - User: `u123456789_user`
   - Password: `xxxxxxxx`

#### B) Email Ayarla
1. Hostinger Panel → **Email Accounts**
2. Yeni email: `noreply@alienes.me`
3. Şifreyi kaydet
4. SMTP:
   - Host: `smtp.hostinger.com`
   - Port: `465`
   - Encryption: `SSL`

### 3️⃣ Yükle ve Kur

#### A) Dosyaları Yükle
1. Hostinger → **File Manager**
2. `domains/alienes.me` klasörüne git
3. `alienes-portfolio-hostinger.zip` yükle
4. **Extract** (Aç) butonuna tıkla

#### B) SSH ile Kur
```bash
# SSH'ye bağlan
ssh u123456789@yourdomain.com

# Dizine git
cd domains/alienes.me

# public_html'i hazırla
rm -rf public_html/*
mv public/* public_html/
mv public/.htaccess public_html/
rmdir public

# .env'i hazırla
cp .env.hostinger .env
nano .env
```

**.env'de değiştir:**
```env
APP_URL=https://alienes.me

DB_DATABASE=u123456789_portfolio
DB_USERNAME=u123456789_user
DB_PASSWORD=database_şifreniz

MAIL_USERNAME=noreply@alienes.me
MAIL_PASSWORD=email_şifreniz
```

Kaydet: `CTRL+O`, Enter, Çık: `CTRL+X`

#### C) Kurulumu Tamamla
```bash
# Kurulum scriptini çalıştır
chmod +x hostinger-setup.sh
./hostinger-setup.sh
```

Admin bilgilerini gir:
- Email: `admin@alienes.me`
- Şifre: (güçlü bir şifre)

## ✅ Test Et

1. **Ana sayfa:** https://alienes.me
2. **Admin giriş:** https://alienes.me/admin/login
3. **Contact form** dene
4. **Email** geldi mi kontrol et

## 🎉 HAZIR!

Tebrikler! Siteniz yayında!

---

## 📋 Detaylı Bilgi

Tüm detaylar için: `HOSTINGER_KURULUM.md`

## 🆘 Sorun mu var?

```bash
# Log kontrol
tail -50 storage/logs/laravel.log

# Cache temizle
php artisan cache:clear
php artisan config:clear
```

---

**Tahmini süre:** 10-15 dakika
**Gerekli:** Database ve Email bilgileri
