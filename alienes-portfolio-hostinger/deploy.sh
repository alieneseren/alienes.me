#!/bin/bash

# Alienes Portfolio - Production Deployment Script
# Bu script'i çalıştırmadan önce mutlaka yedek alın!

echo "🚀 Alienes Portfolio - Production Deployment Başlıyor..."
echo "=================================================="
echo ""

# Renk kodları
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Hata durumunda çık
set -e

echo "📋 1. Git güncellemelerini çekiyorum..."
git pull origin main

echo ""
echo "📦 2. Composer bağımlılıklarını yüklüyorum..."
composer install --no-dev --optimize-autoloader

echo ""
echo "📦 3. NPM bağımlılıklarını yüklüyorum..."
npm install

echo ""
echo "🏗️  4. Frontend asset'leri build ediyorum..."
npm run build

echo ""
echo "🔄 5. Database migration'ları çalıştırıyorum..."
read -p "Migration çalıştırılsın mı? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan migrate --force
fi

echo ""
echo "🧹 6. Cache temizleniyor..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "⚡ 7. Cache oluşturuluyor..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "🔐 8. Dosya izinleri ayarlanıyor..."
chmod -R 755 storage bootstrap/cache
chmod 600 .env

echo ""
echo "🧪 9. Sistem kontrolü yapılıyor..."
php artisan about

echo ""
echo -e "${GREEN}✅ Deployment başarıyla tamamlandı!${NC}"
echo ""
echo -e "${YELLOW}⚠️  Önemli Hatırlatmalar:${NC}"
echo "   1. .env dosyasında database ve mail ayarlarını kontrol edin"
echo "   2. SSL sertifikası kuruluysa .htaccess'te HTTPS yönlendirmesini aktif edin"
echo "   3. Admin panelde sosyal medya linklerini kontrol edin"
echo "   4. Contact form'u test edin"
echo ""
echo "📧 Sorun yaşarsanız: hata loglarını kontrol edin"
echo "   Loglar: storage/logs/laravel.log"
echo ""
