#!/bin/bash

# SSH parametreleri
HOSTINGER_USER="u233064020"
HOSTINGER_HOST="147.93.92.23"
HOSTINGER_PORT="65002"
HOSTINGER_PATH="/home/u233064020/domains/alienes.me"

echo "🚀 Tüm Admin UI Güncellemeleri Deploy Ediliyor..."

echo "1. Dashboard güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/dashboard.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/

echo ""
echo "2. Projeler modülü güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/projects/ \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/projects/

echo ""
echo "3. Deneyimler modülü güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/experiences/index.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/experiences/

echo ""
echo "4. Eğitim modülü güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/educations/index.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/educations/

echo ""
echo "5. Yetenekler modülü güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/skills/index.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/skills/

echo ""
echo "6. Mesajlar modülü güncelleniyor..."
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    resources/views/admin/contacts/index.blade.php \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/resources/views/admin/contacts/

echo ""
echo "7. Cache temizleniyor..."
ssh -p ${HOSTINGER_PORT} ${HOSTINGER_USER}@${HOSTINGER_HOST} "cd ${HOSTINGER_PATH} && php artisan view:clear"

echo ""
echo "✅ Tüm UI Güncellemeleri Tamamlandı!"
