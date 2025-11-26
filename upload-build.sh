#!/bin/bash

echo "==================================="
echo "Build Dosyaları Upload Script"
echo "==================================="

# Önce local'de build yapalım
echo "1. Local build oluşturuluyor..."
npm run build

if [ $? -ne 0 ]; then
    echo "✗ Build başarısız!"
    exit 1
fi

echo "✓ Build tamamlandı"
echo ""

# Hostinger bilgileri
HOSTINGER_USER="u233064020"
HOSTINGER_HOST="147.93.92.23"
HOSTINGER_PORT="65002"
HOSTINGER_PATH="/home/u233064020/domains/alienes.me/public_html/build"

echo "2. Build dosyaları Hostinger'a yükleniyor..."
echo "   Hedef: ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}"
echo ""

# rsync ile dosyaları yükle
rsync -avz --progress -e "ssh -p ${HOSTINGER_PORT}" \
    public/build/ \
    ${HOSTINGER_USER}@${HOSTINGER_HOST}:${HOSTINGER_PATH}/

if [ $? -eq 0 ]; then
    echo ""
    echo "✓ Dosyalar başarıyla yüklendi!"
    echo ""
    echo "Şimdi Hostinger SSH'de şu komutları çalıştırın:"
    echo "  chmod -R 755 /home/u233064020/domains/alienes.me/public_html/build"
    echo "  php artisan view:clear"
    echo "  php artisan config:cache"
else
    echo ""
    echo "✗ Upload başarısız!"
    exit 1
fi
