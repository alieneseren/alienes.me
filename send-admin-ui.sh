#!/bin/bash

echo "🚀 Hostinger'a admin UI güncellemeleri gönderiliyor..."

HOSTINGER_USER="u233064020"
HOSTINGER_HOST="147.93.92.23"
HOSTINGER_PORT="65002"
HOSTINGER_PATH="/home/u233064020/domains/alienes.me"

echo "1️⃣  Admin layout gönderiliyor..."
scp -P ${HOSTINGER_PORT} resources/views/layouts/admin.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/layouts/ 2>/dev/null

echo "2️⃣  Login sayfası gönderiliyor..."
scp -P ${HOSTINGER_PORT} resources/views/admin/auth/login.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/auth/ 2>/dev/null

echo "3️⃣  Cache'ler temizleniyor..."
ssh -p ${HOSTINGER_PORT} ${HOSTINGER_USER}@${HOSTINGER_HOST} \
    "cd ${HOSTINGER_PATH} && php artisan view:clear && php artisan config:clear" 2>/dev/null

echo ""
echo "✅ Güncellemeler tamamlandı!"
echo ""
echo "Test edin:"
echo "  🔐 https://alienes.me/admin/login"
echo "  📊 https://alienes.me/admin/profile"
