#!/bin/bash

# Hostinger için ZIP Paketi Oluşturma
echo "📦 Hostinger için paket hazırlanıyor..."

# Geçici temizlik
echo "🧹 Gereksiz dosyalar temizleniyor..."
rm -rf node_modules vendor

# Production için build
echo "🏗️  Production build yapılıyor..."
npm install
npm run build

# vendor klasörünü temizle (sunucuda yüklenecek)
rm -rf vendor

# ZIP oluştur
echo "📦 ZIP dosyası oluşturuluyor..."
zip -r alienes-portfolio-hostinger.zip . \
    -x "*.git*" \
    -x "*.DS_Store" \
    -x "node_modules/*" \
    -x "vendor/*" \
    -x "*.env" \
    -x ".env.local.backup" \
    -x "storage/logs/*" \
    -x "storage/framework/cache/*" \
    -x "storage/framework/sessions/*" \
    -x "storage/framework/views/*" \
    -x "alienes-portfolio-hostinger.zip"

echo "✅ ZIP dosyası hazır: alienes-portfolio-hostinger.zip"
echo ""
echo "📋 Sonraki adımlar:"
echo "   1. Bu ZIP dosyasını Hostinger'a yükleyin"
echo "   2. HOSTINGER_KURULUM.md dosyasındaki adımları takip edin"
echo ""
echo "📄 ZIP içeriği:"
zip -sf alienes-portfolio-hostinger.zip | head -20
echo "   ..."
echo ""
