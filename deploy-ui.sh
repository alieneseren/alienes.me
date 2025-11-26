#!/bin/bash

# SSH parametreleri
HOSTINGER_USER="u233064020"
HOSTINGER_HOST="147.93.92.23"
HOSTINGER_PORT="65002"
HOSTINGER_PATH="/home/u233064020/domains/alienes.me"

echo "🚀 UI Güncellemeleri Deploy Ediliyor..."

echo "1. Admin Layout güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/layouts/admin.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/layouts/

echo ""
echo "2. CV Form güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/cv/form.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/cv/

echo ""
echo "3. Cache temizleniyor..."
ssh -p ${HOSTINGER_PORT} ${HOSTINGER_USER}@${HOSTINGER_HOST} "cd ${HOSTINGER_PATH} && php artisan view:clear"

echo ""
echo "✅ Deployment Tamamlandı!"
