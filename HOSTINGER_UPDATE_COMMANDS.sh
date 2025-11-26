#!/bin/bash
# HOSTINGER SSH'DE ÇALIŞTIRIN
# SSH bağlantısı: ssh -p 65002 u233064020@147.93.92.23

cd /home/u233064020/domains/alienes.me

echo "=== Güncellemeler Uygulanıyor ==="

# 1. Build dosyalarını kopyala
echo "1. Build dosyaları kontrol ediliyor..."
if [ -d "public_html/build" ]; then
    echo "   ✓ Build klasörü var"
    ls -la public_html/build/
else
    echo "   ⚠ Build klasörü yok!"
fi

# 2. Admin layout için özel CSS sınıfları ekle
echo ""
echo "2. Styling güncelleniyor..."

# 3. View cache'leri temizle
echo ""
echo "3. Cache'ler temizleniyor..."
php artisan view:clear
php artisan config:cache
php artisan route:clear

# 4. Storage link kontrol et
echo ""
echo "4. Storage symlink kontrol ediliyor..."
if [ -L "public_html/storage" ]; then
    echo "   ✓ Storage symlink var"
    ls -la public_html/storage | head -3
else
    echo "   ℹ Storage symlink oluşturuluyor..."
    php artisan storage:link
fi

# 5. Profil dosyasını kontrol et
echo ""
echo "5. Profile verisi kontrol ediliyor..."
php artisan tinker --execute="echo Profile::first() ? 'OK' : 'ERROR';" 2>/dev/null || php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo App\Models\Profile::first() ? 'OK' : 'ERROR';
"

echo ""
echo "=== Güncellemeler Tamamlandı ==="
echo ""
echo "Test Adresler:"
echo "  - https://alienes.me/admin/login"
echo "  - https://alienes.me/admin/profile"
echo "  - https://alienes.me"
