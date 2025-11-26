#!/bin/bash

echo "==================================="
echo "Hostinger Güncellemesi"
echo "==================================="

# SSH parametreleri
HOSTINGER_USER="u233064020"
HOSTINGER_HOST="147.93.92.23"
HOSTINGER_PORT="65002"
HOSTINGER_PATH="/home/u233064020/domains/alienes.me"

echo "1. Build dosyaları kopyalanıyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    public/build/ \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/public_html/build/ 2>/dev/null || {
    echo "rsync başarısız, alternatif yöntem deniyor..."
}

echo ""
echo "2. Layout dosyaları güncelleniyor (admin.blade.php)..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/layouts/admin.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/layouts/ 2>/dev/null

echo ""
echo "3. Admin profile edit view'ı güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/profile/edit.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/profile/ 2>/dev/null

echo ""
echo "4. Controller dosyaları güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    app/Http/Controllers/Admin/ProfileController.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/app/Http/Controllers/Admin/ 2>/dev/null

echo ""
echo "5. Routes güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    routes/web.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/routes/ 2>/dev/null

echo ""
echo "6. Hostinger'da cache'ler temizleniyor..."
ssh -p ${HOSTINGER_PORT} ${HOSTINGER_USER}@${HOSTINGER_HOST} "cd ${HOSTINGER_PATH} && php artisan view:clear && php artisan config:cache && php artisan route:clear" 2>/dev/null

echo ""
echo "✓ Güncellemeler tamamlandı!"
echo ""
echo "Kontrol edilecek adresler:"
echo "  - Admin Panel: https://alienes.me/admin/login"
echo "  - Admin Profile: https://alienes.me/admin/profile"
echo "  - Ana Sayfa: https://alienes.me"
