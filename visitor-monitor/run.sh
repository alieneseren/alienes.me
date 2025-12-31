#!/bin/bash

# alienes.me Ziyaretçi Takip Uygulaması Başlatıcı

cd "$(dirname "$0")"

# Sanal ortam var mı kontrol et
if [ ! -d "venv" ]; then
    echo "🔧 Sanal ortam oluşturuluyor..."
    python3 -m venv venv
fi

# Sanal ortamı aktif et
source venv/bin/activate

# Bağımlılıkları yükle
echo "📦 Bağımlılıklar kontrol ediliyor..."
pip install -q -r requirements.txt

# Uygulamayı başlat (PyQt6 versiyonu)
echo "🚀 Uygulama başlatılıyor..."
python3 visitor_monitor_qt.py
