# alienes.me Ziyaretçi Takip Uygulaması

Web sitenize gelen ziyaretçileri gerçek zamanlı olarak masaüstünüzden izleyin.

## Özellikler

- 📊 Günlük ziyaretçi sayısı
- 👥 Anlık aktif ziyaretçiler
- 📈 Haftalık istatistikler
- 📋 Son aktivite logları
- 🌍 Ülke ve cihaz bilgileri
- 🔄 5 saniyelik otomatik yenileme

## Kurulum

### Gereksinimler
- Python 3.8+
- tkinter (genelde Python ile birlikte gelir)

### Bağımlılıkları Yükle

```bash
cd visitor-monitor
pip3 install -r requirements.txt
```

### macOS'ta tkinter

macOS'ta tkinter genelde yüklüdür. Yoksa:

```bash
brew install python-tk
```

## Çalıştırma

```bash
python3 visitor_monitor.py
```

Veya:

```bash
chmod +x run.sh
./run.sh
```

## API Endpoint'leri

Uygulama şu API endpoint'lerini kullanır:

| Endpoint | Açıklama |
|----------|----------|
| `/api/visitor-count` | Bugünkü sayı ve anlık aktif |
| `/api/visitor-count/dashboard` | Tüm dashboard verileri |
| `/api/visitor-count/active` | Aktif ziyaretçi detayları |
| `/api/visitor-count/logs` | Son ziyaret logları |
| `/api/visitor-count/stream` | SSE gerçek zamanlı stream |
| `/api/visitor-count/stats` | 7 günlük istatistikler |

## Ekran Görüntüsü

```
┌─────────────────────────────────────────────────────┐
│ 🌐 alienes.me Ziyaretçi Takip          ● Bağlı     │
├─────────────────────────────────────────────────────┤
│  📊 Bugün    👥 Anlık    📈 Haftalık   📉 Değişim  │
│     42          3           156          +12%      │
├──────────────────────┬──────────────────────────────┤
│ 👥 Aktif Ziyaretçiler│ 📋 Son Aktiviteler          │
│ Sayfa | Cihaz | ...  │ Zaman | Sayfa | Cihaz | ... │
│ /     | mobile| ...  │ 2dk   | /blog | desktop|...  │
└──────────────────────┴──────────────────────────────┘
```

## Yapılandırma

`visitor_monitor.py` içindeki değişkenleri düzenleyebilirsiniz:

```python
API_BASE_URL = "https://alienes.me/api/visitor-count"
REFRESH_INTERVAL = 5000  # milisaniye
```

## Lisans

MIT License
