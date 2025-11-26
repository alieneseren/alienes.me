#!/bin/bash

echo "======================================"
echo "  Alienes.me - Hızlı Başlangıç"
echo "======================================"
echo ""

# Composer olmadan da çalışabilmesi için basit bir kurulum
echo "🗄️  Veritabanı hazırlanıyor..."
touch database/database.sqlite 2>/dev/null

# Manuel olarak key oluştur
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo "🔑 Uygulama anahtarı oluşturuluyor..."
    KEY=$(openssl rand -base64 32)
    if [ -f .env ]; then
        sed -i.bak "s/APP_KEY=/APP_KEY=base64:$KEY/" .env
    else
        cp .env.example .env
        sed -i.bak "s/APP_KEY=/APP_KEY=base64:$KEY/" .env
    fi
fi

echo ""
echo "✅ Temel kurulum tamamlandı!"
echo ""
echo "📚 Tam kurulum için (önerilir):"
echo "   ./install.sh"
echo ""
echo "🚀 Veya composer kurulu ise:"
echo "   composer install"
echo "   php artisan migrate --seed"
echo "   npm install && npm run build"
echo "   php artisan serve"
echo ""
