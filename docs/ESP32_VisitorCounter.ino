/*
 * ESP32 Web Sitesi Ziyaretçi Sayacı
 * alienes.me web sitesinin günlük ziyaretçi sayısını ekranda gösterir
 * 
 * Gerekli Kütüphaneler:
 * - WiFi.h (ESP32 için dahili)
 * - HTTPClient.h (ESP32 için dahili)
 * - ArduinoJson (Library Manager'dan yükle)
 * - Kullandığın ekran kütüphanesi (örn: Adafruit_SSD1306, TFT_eSPI vb.)
 */

#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// WiFi Ayarları
const char* ssid = "WIFI_ADINIZ";
const char* password = "WIFI_SIFRENIZ";

// API Endpoint
const char* apiUrl = "https://alienes.me/api/visitor-count";
// Basit sayı için: "https://alienes.me/api/visitor-count/simple"

// Güncelleme aralığı (milisaniye)
const unsigned long UPDATE_INTERVAL = 60000; // 1 dakika

unsigned long lastUpdate = 0;
int visitorCount = 0;
String currentDate = "";

void setup() {
  Serial.begin(115200);
  delay(1000);
  
  // Ekranı başlat (kendi ekran kodunu buraya ekle)
  // display.begin();
  // display.clearDisplay();
  
  Serial.println("ESP32 Ziyaretçi Sayacı Başlatılıyor...");
  
  // WiFi'a bağlan
  connectToWiFi();
  
  // İlk veriyi çek
  fetchVisitorCount();
}

void loop() {
  // WiFi bağlantısını kontrol et
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi bağlantısı kesildi, yeniden bağlanılıyor...");
    connectToWiFi();
  }
  
  // Belirli aralıklarla güncelle
  if (millis() - lastUpdate >= UPDATE_INTERVAL) {
    fetchVisitorCount();
    lastUpdate = millis();
  }
  
  delay(100);
}

void connectToWiFi() {
  Serial.print("WiFi'a bağlanılıyor: ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 30) {
    delay(500);
    Serial.print(".");
    attempts++;
  }
  
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println();
    Serial.println("WiFi bağlandı!");
    Serial.print("IP Adresi: ");
    Serial.println(WiFi.localIP());
  } else {
    Serial.println();
    Serial.println("WiFi bağlantısı başarısız!");
  }
}

void fetchVisitorCount() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi bağlı değil!");
    return;
  }
  
  HTTPClient http;
  
  Serial.println("Ziyaretçi sayısı alınıyor...");
  
  http.begin(apiUrl);
  http.addHeader("Accept", "application/json");
  
  int httpCode = http.GET();
  
  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println("Yanıt: " + payload);
      
      // JSON'u parse et
      StaticJsonDocument<200> doc;
      DeserializationError error = deserializeJson(doc, payload);
      
      if (!error) {
        currentDate = doc["date"].as<String>();
        visitorCount = doc["count"].as<int>();
        
        Serial.print("Tarih: ");
        Serial.println(currentDate);
        Serial.print("Ziyaretçi Sayısı: ");
        Serial.println(visitorCount);
        
        // Ekranı güncelle
        updateDisplay();
      } else {
        Serial.println("JSON parse hatası!");
      }
    }
  } else {
    Serial.print("HTTP hatası: ");
    Serial.println(http.errorToString(httpCode));
  }
  
  http.end();
}

// Basit sayı API'si için alternatif fonksiyon
void fetchVisitorCountSimple() {
  if (WiFi.status() != WL_CONNECTED) return;
  
  HTTPClient http;
  http.begin("https://alienes.me/api/visitor-count/simple");
  
  int httpCode = http.GET();
  
  if (httpCode == HTTP_CODE_OK) {
    String payload = http.getString();
    visitorCount = payload.toInt();
    Serial.print("Ziyaretçi: ");
    Serial.println(visitorCount);
    updateDisplay();
  }
  
  http.end();
}

void updateDisplay() {
  // ÖRNEK: OLED SSD1306 Ekran için
  // Kendi ekran kodunuzu buraya ekleyin
  
  /*
  display.clearDisplay();
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 0);
  display.println("alienes.me");
  display.println("Ziyaretci Sayaci");
  display.println("");
  display.setTextSize(3);
  display.print(visitorCount);
  display.setTextSize(1);
  display.println(" kisi");
  display.println("");
  display.print("Tarih: ");
  display.println(currentDate);
  display.display();
  */
  
  // Serial Monitor'a yazdır (test için)
  Serial.println("=== EKRAN ===");
  Serial.println("alienes.me");
  Serial.println("Günlük Ziyaretçi");
  Serial.print(">>> ");
  Serial.print(visitorCount);
  Serial.println(" kişi <<<");
  Serial.print("Tarih: ");
  Serial.println(currentDate);
  Serial.println("=============");
}

/*
 * API Endpoints:
 * 
 * 1. JSON Response (Önerilen):
 *    GET https://alienes.me/api/visitor-count
 *    Response: {"date": "2025-11-27", "count": 42}
 * 
 * 2. Sadece Sayı (Minimal):
 *    GET https://alienes.me/api/visitor-count/simple
 *    Response: 42
 * 
 * 3. Son 7 Gün İstatistikleri:
 *    GET https://alienes.me/api/visitor-count/stats
 *    Response: {"total_7_days": 250, "today": 42, "daily": [...]}
 * 
 * 4. Belirli Tarih:
 *    GET https://alienes.me/api/visitor-count/2025-11-27
 *    Response: {"date": "2025-11-27", "count": 42}
 */
