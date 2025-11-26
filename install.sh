#!/bin/bash

echo "======================================"
echo "  Alienes.me Portfolio Kurulum"
echo "======================================"
echo ""

# Composer bağımlılıklarını yükle
echo "📦 Composer bağımlılıkları yükleniyor..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# .env dosyasını kontrol et
if [ ! -f .env ]; then
    echo "📝 .env dosyası oluşturuluyor..."
    cp .env.example .env
fi

# Uygulama anahtarı oluştur
echo "🔑 Uygulama anahtarı oluşturuluyor..."
php artisan key:generate

# Veritabanını oluştur
echo "🗄️  Veritabanı oluşturuluyor..."
touch database/database.sqlite

# Migrasyonları çalıştır
echo "📊 Veritabanı tabloları oluşturuluyor..."
php artisan migrate --force

# Seeders'ı çalıştır
echo "🌱 Örnek veriler ekleniyor..."
php artisan db:seed --force

# Storage linkini oluştur
echo "🔗 Storage linki oluşturuluyor..."
php artisan storage:link

# NPM bağımlılıklarını yükle
echo "📦 NPM bağımlılıkları yükleniyor..."
npm install

# Asset'leri derle
echo "🎨 Asset'ler derleniyor..."
npm run build

echo ""
echo "✅ Kurulum tamamlandı!"
echo ""
echo "======================================"
echo "  Kullanım Bilgileri"
echo "======================================"
echo ""
echo "🚀 Sunucuyu başlatmak için:"
echo "   php artisan serve"
echo ""
echo "🌐 Site: http://localhost:8000"
echo "🔐 Admin: http://localhost:8000/admin/login"
echo ""
echo "📧 Admin Giriş Bilgileri:"
echo "   Email: admin@alienes.me"
echo "   Şifre: password"
echo ""
echo "⚠️  Güvenlik için şifrenizi değiştirmeyi unutmayın!"
echo ""
