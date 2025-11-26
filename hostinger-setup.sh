#!/bin/bash

# Alienes Portfolio - Hostinecho "✓ Admin kullanıcısı zaten mevcut"
fi

# Build dosyalarını public'ten public_html'e kopyala
echo ""
echo "7. Build dosyaları kopyalanıyor..."
if [ -d "public/build" ]; then
    echo "public/build klasörü bulundu, kopyalanıyor..."
    mkdir -p public_html/build
    cp -r public/build/* public_html/build/
    chmod -R 755 public_html/build
    echo "✓ Build dosyaları public_html/build/ klasörüne kopyalandı"
else
    echo "⚠ public/build klasörü bulunamadı"
fi

# Cache'leri temizle ve yeniden oluştur
echo ""
echo "8. Cache'ler oluşturuluyor..."
php artisan config:cache
php artisan route:cache
php artisan view:cacherulum
# Bu script Hostinger'a yüklendikten sonra çalıştırılacak

echo "🚀 Hostinger Kurulum Başlıyor..."
echo "=================================="

# Renk kodları
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Çalışma dizini
cd "$(dirname "$0")"

echo ""
echo -e "${BLUE}📋 1. .env dosyası hazırlanıyor...${NC}"
if [ ! -f .env ]; then
    cp .env.hostinger .env
    echo -e "${GREEN}✅ .env dosyası oluşturuldu${NC}"
else
    echo -e "${YELLOW}⚠️  .env dosyası zaten mevcut${NC}"
fi

echo ""
echo -e "${BLUE}🔐 2. Uygulama anahtarı oluşturuluyor...${NC}"
php artisan key:generate --force
echo -e "${GREEN}✅ APP_KEY oluşturuldu${NC}"

echo ""
echo -e "${BLUE}📦 3. Composer bağımlılıkları yükleniyor...${NC}"
composer install --no-dev --optimize-autoloader --no-interaction

echo ""
echo -e "${BLUE}🗄️  4. Database migration'ları çalıştırılıyor...${NC}"
php artisan migrate --force

echo ""
echo -e "${BLUE}👤 5. Admin kullanıcısı oluşturuluyor...${NC}"
echo -e "${YELLOW}Lütfen admin bilgilerinizi girin:${NC}"
read -p "Admin Email: " ADMIN_EMAIL
read -sp "Admin Şifre: " ADMIN_PASSWORD
echo ""

php artisan tinker --execute="
\$user = new App\Models\User();
\$user->name = 'Admin';
\$user->email = '$ADMIN_EMAIL';
\$user->password = bcrypt('$ADMIN_PASSWORD');
\$user->save();
echo 'Admin kullanıcısı oluşturuldu!';
"

echo ""
echo -e "${BLUE}⚡  6. Cache oluşturuluyor...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo -e "${BLUE}🔒 7. Dosya izinleri ayarlanıyor...${NC}"
chmod -R 755 storage bootstrap/cache
chmod 600 .env

echo ""
echo -e "${GREEN}✅ KURULUM TAMAMLANDI!${NC}"
echo ""
echo -e "${YELLOW}📝 ÖNEMLİ HATIRLATMALAR:${NC}"
echo "   1. .env dosyasında database bilgilerini güncelleyin"
echo "   2. .env dosyasında email bilgilerini güncelleyin"
echo "   3. Admin panel: https://your-domain.com/admin/login"
echo "   4. Email: $ADMIN_EMAIL"
echo ""
echo -e "${BLUE}🔧 Sonraki adım:${NC}"
echo "   nano .env"
echo "   (DB_* ve MAIL_* değerlerini Hostinger'dan alın)"
echo ""
