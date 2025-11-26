#!/bin/bash

echo "🚀 Alienes.me Portfolio başlatılıyor..."
echo ""

# Veritabanı kontrolü
if [ ! -f database/database.sqlite ]; then
    echo "⚠️  Veritabanı bulunamadı!"
    echo "Lütfen önce kurulum yapın: ./install.sh"
    exit 1
fi

# Port kontrolü
PORT=8000
if lsof -Pi :$PORT -sTCP:LISTEN -t >/dev/null ; then
    echo "⚠️  Port $PORT zaten kullanımda!"
    echo "Farklı bir port kullanmak için:"
    echo "php artisan serve --port=8080"
    exit 1
fi

echo "✅ Sunucu başlatılıyor..."
echo ""
echo "======================================"
echo "  🌐 Site: http://localhost:8000"
echo "  🔐 Admin: http://localhost:8000/admin/login"
echo "======================================"
echo ""
echo "  📧 Admin: admin@alienes.me"
echo "  🔑 Şifre: password"
echo ""
echo "  Durdurmak için: Ctrl+C"
echo "======================================"
echo ""

php artisan serve
