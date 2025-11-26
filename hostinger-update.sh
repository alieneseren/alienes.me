#!/bin/bash

echo "🚀 Hostinger Güncellemesi Başlıyor..."

HOSTINGER_USER="u233064020"
HOSTINGER_HOST="147.93.92.23"
HOSTINGER_PORT="65002"
HOSTINGER_PATH="/home/u233064020/domains/alienes.me"

echo ""
echo "1️⃣  Build dosyaları kopyalanıyor..."
mkdir -p public/build/assets 2>/dev/null
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    public/build/ \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/public_html/build/ 2>/dev/null || echo "   ⚠️  rsync sorun yaşadı, FTP ile yükleyin"

echo ""
echo "2️⃣  Controller dosyaları güncelleniyor..."
scp -P ${HOSTINGER_PORT} app/Http/Controllers/ContactController.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/app/Http/Controllers/ 2>/dev/null
scp -P ${HOSTINGER_PORT} app/Http/Controllers/Admin/ProfileController.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/app/Http/Controllers/Admin/ 2>/dev/null

echo ""
echo "3️⃣  Mail/Mailable dosyaları güncelleniyor..."
scp -P ${HOSTINGER_PORT} app/Mail/ContactFormMail.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/app/Mail/ 2>/dev/null

echo ""
echo "4️⃣  View dosyaları güncelleniyor..."
scp -P ${HOSTINGER_PORT} resources/views/admin/profile/edit.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/profile/ 2>/dev/null
scp -P ${HOSTINGER_PORT} resources/views/emails/contact-form.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/emails/ 2>/dev/null

echo ""
echo "5️⃣  Routes güncelleniyor..."
scp -P ${HOSTINGER_PORT} routes/web.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/routes/ 2>/dev/null

echo ""
echo "6️⃣  Hostinger'da cache'ler temizleniyor..."
ssh -p ${HOSTINGER_PORT} ${HOSTINGER_USER}@${HOSTINGER_HOST} \
    "cd ${HOSTINGER_PATH} && php artisan view:clear && php artisan config:cache && php artisan route:clear" 2>/dev/null

echo ""
echo "✅ Güncellemeler tamamlandı!"
echo ""
echo "Test Edin:"
echo "  🔗 https://alienes.me/admin/profile"
echo "  🔗 https://alienes.me/contact"
