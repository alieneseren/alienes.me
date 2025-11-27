# ESP32 Ziyaretçi Sayacı - alienes.me

ESP32 ile alienes.me web sitesinin günlük ziyaretçi sayısını OLED ekranda gösteren proje.

## Donanım Gereksinimleri

- ESP32 DevKit (veya benzeri)
- SSD1306 OLED Ekran (128x64, I2C)
- Jumper kablolar

## Bağlantı Şeması

| OLED Pin | ESP32 Pin |
|----------|-----------|
| VCC      | 3.3V      |
| GND      | GND       |
| SDA      | GPIO 21   |
| SCL      | GPIO 22   |

## Kurulum

### 1. PlatformIO Kurulumu (VS Code)

VS Code'da PlatformIO eklentisi zaten yüklü olmalı.

### 2. Projeyi Aç

```bash
cd esp32-visitor-counter
```

VS Code'da bu klasörü açın.

### 3. WiFi Bilgilerini Düzenle

`src/main.cpp` dosyasında WiFi bilgilerinizi güncelleyin:

```cpp
const char* WIFI_SSID = "WIFI_ADINIZ";
const char* WIFI_PASSWORD = "WIFI_SIFRENIZ";
```

### 4. Yükle

1. ESP32'yi USB ile bağlayın
2. PlatformIO'da **Upload** butonuna tıklayın (→ oku)
3. Veya terminal: `pio run -t upload`

### 5. Seri Monitör

Hata ayıklama için:
- PlatformIO'da **Serial Monitor** açın
- Veya: `pio device monitor`

## API Endpoints

Web sitesi şu API'leri sağlar:

| Endpoint | Yanıt |
|----------|-------|
| `/api/visitor-count` | `{"date": "2025-11-27", "count": 42}` |
| `/api/visitor-count/simple` | `42` |
| `/api/visitor-count/stats` | Son 7 gün istatistikleri |

## Özellikler

- ✅ Her 1 dakikada otomatik güncelleme
- ✅ WiFi bağlantı kontrolü ve yeniden bağlanma
- ✅ OLED ekranda büyük sayı gösterimi
- ✅ Hata durumlarında bilgilendirme
- ✅ Serial debug çıktısı

## Sorun Giderme

### OLED Ekran Görünmüyor
- I2C adresini kontrol edin (varsayılan: 0x3C)
- Bağlantıları kontrol edin
- 3.3V kullandığınızdan emin olun

### WiFi Bağlanmıyor
- SSID ve şifreyi kontrol edin
- 2.4GHz ağ kullandığınızdan emin olun (ESP32, 5GHz desteklemez)

### API Hatası
- Web sitesinin çalıştığından emin olun
- HTTPS sertifikasını kontrol edin
