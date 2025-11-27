/*
 * ESP32 Web Sitesi Ziyaretçi Sayacı
 * alienes.me web sitesinin günlük ziyaretçi sayısını OLED ekranda gösterir
 * 
 * Donanım:
 * - ESP32 DevKit
 * - SSD1306 OLED 128x64 (I2C)
 *   - SDA -> GPIO 21
 *   - SCL -> GPIO 22
 *   - VCC -> 3.3V
 *   - GND -> GND
 */

#include <Arduino.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>

// ============== YAPILANDIRMA ==============
// WiFi Ayarları - KENDİ BİLGİLERİNİZİ GİRİN
const char* WIFI_SSID = "Yurt";
const char* WIFI_PASSWORD = "yurt12345tokat";

// API Endpoint
const char* API_URL = "https://alienes.me/api/visitor-count";
const char* API_URL_SIMPLE = "https://alienes.me/api/visitor-count/simple";

// Güncelleme aralığı (milisaniye)
const unsigned long UPDATE_INTERVAL = 60000; // 1 dakika

// OLED Ekran Ayarları
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_RESET -1
#define SCREEN_ADDRESS 0x3C

// ============== GLOBAL DEĞİŞKENLER ==============
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

unsigned long lastUpdate = 0;
int visitorCount = 0;
String currentDate = "";
bool wifiConnected = false;
int failedAttempts = 0;

// ============== FONKSİYON TANIMLARI ==============
void setupDisplay();
void connectToWiFi();
void fetchVisitorCount();
void updateDisplay();
void showError(const char* message);
void showConnecting();
void showWiFiStatus();

// ============== SETUP ==============
void setup() {
    Serial.begin(115200);
    delay(1000);
    
    Serial.println("\n================================");
    Serial.println("ESP32 Ziyaretci Sayaci");
    Serial.println("alienes.me");
    Serial.println("================================\n");
    
    // OLED ekranı başlat
    setupDisplay();
    
    // WiFi'a bağlan
    showConnecting();
    connectToWiFi();
    
    if (wifiConnected) {
        // İlk veriyi çek
        fetchVisitorCount();
    }
}

// ============== LOOP ==============
void loop() {
    // WiFi bağlantısını kontrol et
    if (WiFi.status() != WL_CONNECTED) {
        if (wifiConnected) {
            Serial.println("WiFi baglantisi kesildi!");
            wifiConnected = false;
            showError("WiFi Kesildi");
        }
        connectToWiFi();
    }
    
    // Belirli aralıklarla güncelle
    if (wifiConnected && (millis() - lastUpdate >= UPDATE_INTERVAL)) {
        fetchVisitorCount();
    }
    
    delay(100);
}

// ============== OLED EKRAN KURULUMU ==============
void setupDisplay() {
    Serial.println("OLED ekran baslatiliyor...");
    
    if (!display.begin(SSD1306_SWITCHCAPVCC, SCREEN_ADDRESS)) {
        Serial.println("SSD1306 ekran bulunamadi!");
        for(;;); // Sonsuz döngü
    }
    
    display.clearDisplay();
    display.setTextColor(SSD1306_WHITE);
    display.setTextSize(1);
    display.setCursor(0, 0);
    display.println("Baslatiliyor...");
    display.display();
    
    Serial.println("OLED ekran hazir!");
}

// ============== WIFI BAĞLANTISI ==============
void connectToWiFi() {
    Serial.print("WiFi'a baglaniliyor: ");
    Serial.println(WIFI_SSID);
    
    WiFi.mode(WIFI_STA);
    WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
    
    int attempts = 0;
    while (WiFi.status() != WL_CONNECTED && attempts < 30) {
        delay(500);
        Serial.print(".");
        
        // Ekranda bağlanma animasyonu
        display.clearDisplay();
        display.setTextSize(1);
        display.setCursor(0, 0);
        display.println("WiFi Baglaniyor");
        display.println(WIFI_SSID);
        display.println();
        
        // Animasyonlu noktalar
        String dots = "";
        for (int i = 0; i < (attempts % 4); i++) {
            dots += ".";
        }
        display.setTextSize(2);
        display.setCursor(40, 35);
        display.println(dots);
        display.display();
        
        attempts++;
    }
    
    if (WiFi.status() == WL_CONNECTED) {
        wifiConnected = true;
        failedAttempts = 0;
        
        Serial.println();
        Serial.println("WiFi baglandi!");
        Serial.print("IP Adresi: ");
        Serial.println(WiFi.localIP());
        
        showWiFiStatus();
        delay(2000);
    } else {
        wifiConnected = false;
        Serial.println();
        Serial.println("WiFi baglantisi basarisiz!");
        showError("WiFi Hata!");
    }
}

// ============== API'DEN VERİ ÇEK ==============
void fetchVisitorCount() {
    if (WiFi.status() != WL_CONNECTED) {
        Serial.println("WiFi bagli degil!");
        return;
    }
    
    HTTPClient http;
    
    Serial.println("Ziyaretci sayisi aliniyor...");
    
    // HTTPS için güvenlik sertifikasını atla (geliştirme için)
    http.begin(API_URL);
    http.addHeader("Accept", "application/json");
    http.setTimeout(10000); // 10 saniye timeout
    
    int httpCode = http.GET();
    
    if (httpCode > 0) {
        if (httpCode == HTTP_CODE_OK) {
            String payload = http.getString();
            Serial.println("Yanit: " + payload);
            
            // JSON'u parse et
            JsonDocument doc;
            DeserializationError error = deserializeJson(doc, payload);
            
            if (!error) {
                currentDate = doc["date"].as<String>();
                visitorCount = doc["count"].as<int>();
                failedAttempts = 0;
                
                Serial.print("Tarih: ");
                Serial.println(currentDate);
                Serial.print("Ziyaretci Sayisi: ");
                Serial.println(visitorCount);
                
                // Ekranı güncelle
                updateDisplay();
            } else {
                Serial.print("JSON parse hatasi: ");
                Serial.println(error.c_str());
                showError("JSON Hata");
            }
        } else {
            Serial.print("HTTP hata kodu: ");
            Serial.println(httpCode);
            showError("HTTP Hata");
        }
    } else {
        failedAttempts++;
        Serial.print("HTTP hatasi: ");
        Serial.println(http.errorToString(httpCode));
        
        if (failedAttempts > 3) {
            showError("Baglanti Yok");
        }
    }
    
    http.end();
    lastUpdate = millis();
}

// ============== EKRANI GÜNCELLE ==============
void updateDisplay() {
    display.clearDisplay();
    
    // Başlık
    display.setTextSize(1);
    display.setCursor(0, 0);
    display.println("alienes.me");
    
    // Ayırıcı çizgi
    display.drawLine(0, 10, SCREEN_WIDTH, 10, SSD1306_WHITE);
    
    // Alt başlık
    display.setCursor(0, 14);
    display.println("Gunluk Ziyaretci");
    
    // Büyük sayı
    display.setTextSize(4);
    
    // Sayıyı ortala
    String countStr = String(visitorCount);
    int16_t x1, y1;
    uint16_t w, h;
    display.getTextBounds(countStr, 0, 0, &x1, &y1, &w, &h);
    int xPos = (SCREEN_WIDTH - w) / 2;
    
    display.setCursor(xPos, 26);
    display.println(visitorCount);
    
    // Tarih (altta)
    display.setTextSize(1);
    display.setCursor(0, 56);
    display.print("Tarih: ");
    display.println(currentDate);
    
    display.display();
    
    // Serial'e de yazdır
    Serial.println("=== EKRAN GUNCELLENDI ===");
    Serial.print("Ziyaretci: ");
    Serial.println(visitorCount);
}

// ============== HATA MESAJI GÖSTER ==============
void showError(const char* message) {
    display.clearDisplay();
    
    display.setTextSize(1);
    display.setCursor(0, 0);
    display.println("alienes.me");
    display.drawLine(0, 10, SCREEN_WIDTH, 10, SSD1306_WHITE);
    
    // Hata ikonu (X)
    display.drawLine(54, 20, 74, 40, SSD1306_WHITE);
    display.drawLine(74, 20, 54, 40, SSD1306_WHITE);
    
    display.setTextSize(1);
    display.setCursor(0, 50);
    display.println(message);
    
    display.display();
}

// ============== BAĞLANIYOR EKRANI ==============
void showConnecting() {
    display.clearDisplay();
    
    display.setTextSize(1);
    display.setCursor(0, 0);
    display.println("alienes.me");
    display.drawLine(0, 10, SCREEN_WIDTH, 10, SSD1306_WHITE);
    
    display.setCursor(0, 20);
    display.println("WiFi'a baglaniliyor...");
    display.println();
    display.println(WIFI_SSID);
    
    display.display();
}

// ============== WIFI DURUMU GÖSTER ==============
void showWiFiStatus() {
    display.clearDisplay();
    
    display.setTextSize(1);
    display.setCursor(0, 0);
    display.println("alienes.me");
    display.drawLine(0, 10, SCREEN_WIDTH, 10, SSD1306_WHITE);
    
    display.setCursor(0, 20);
    display.println("WiFi Baglandi!");
    display.println();
    display.print("IP: ");
    display.println(WiFi.localIP());
    display.println();
    display.println("Veri aliniyor...");
    
    display.display();
}
