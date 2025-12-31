/*
 * ESP32 Ziyaretçi Sayacı - U8g2 Kütüphanesi
 * alienes.me websitesinin günlük ve anlık ziyaretçi sayısını OLED ekranda gösterir
 * Her saniye veritabanına kayıt yapar, akıllı silme mantığı ile optimize eder
 */

#include <Arduino.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ArduinoJson.h>
#include <Wire.h>
#include <U8g2lib.h>

// WiFi bilgileri (bilinen ağlar ve şifreleri)
// Eğer cihaz otomatik bağlanamazsa, buraya sıralamayı güncelleyin
const char* knownSsids[] = {"Yurt", "AliEnes"};
const char* knownPasswords[] = {"yurt12345tokat", "enderwillyimson"};
const int KNOWN_SSID_COUNT = sizeof(knownSsids) / sizeof(knownSsids[0]);

// API URL'leri
const char* apiUrl = "https://alienes.me/api/visitor-count";
const char* logApiUrl = "https://alienes.me/api/visitor-count/esp32-log";
const char* ESP32_TOKEN = "esp32_secret_token_2024";

// OLED ekran - U8g2 (SSD1306 128x64 I2C)
U8G2_SSD1306_128X64_NONAME_F_HW_I2C display(U8G2_R0, /* reset=*/ U8X8_PIN_NONE);

// Güncelleme aralığı (ms) - 1 saniye
const unsigned long UPDATE_INTERVAL = 1000;
unsigned long lastUpdate = 0;

int visitorCount = 0;
int activeVisitors = 0;
int lastLoggedCount = -1; // Son loglanan ziyaretçi sayısı
String currentDate = "";
bool displayOK = false;

// Fonksiyon prototipleri
void logToDatabase(int count);

// WiFi durum kodunu string'e çevirir
const char* wifiStatusToString(wl_status_t s) {
    switch (s) {
        case WL_IDLE_STATUS: return "WL_IDLE_STATUS";
        case WL_NO_SHIELD: return "WL_NO_SHIELD";
        case WL_NO_SSID_AVAIL: return "WL_NO_SSID_AVAIL";
        case WL_SCAN_COMPLETED: return "WL_SCAN_COMPLETED";
        case WL_CONNECTED: return "WL_CONNECTED";
        case WL_CONNECT_FAILED: return "WL_CONNECT_FAILED";
        case WL_CONNECTION_LOST: return "WL_CONNECTION_LOST";
        case WL_DISCONNECTED: return "WL_DISCONNECTED";
        default: return "UNKNOWN";
    }
}

void initDisplay() {
    Serial.println(F("OLED ekran baslatiliyor (U8g2)..."));
    
    Wire.begin(21, 22);
    delay(100);
    
    if (display.begin()) {
        displayOK = true;
        Serial.println(F("OLED ekran baslatildi!"));
        
        display.clearBuffer();
        display.setFont(u8g2_font_ncenB14_tr);
        display.drawStr(10, 30, "MERHABA!");
        display.setFont(u8g2_font_ncenB08_tr);
        display.drawStr(10, 50, "Baslatiliyor...");
        display.sendBuffer();
        
        Serial.println(F("Test mesaji gosterildi"));
        delay(2000);
    } else {
        Serial.println(F("OLED ekran baslatilamadi!"));
    }
}

void showConnecting() {
    if (!displayOK) return;
    display.clearBuffer();
    display.setFont(u8g2_font_ncenB10_tr);
    display.drawStr(0, 25, "WiFi'ye");
    display.drawStr(0, 45, "baglaniliyor...");
    display.sendBuffer();
}

void showWiFiConnected() {
    if (!displayOK) return;
    display.clearBuffer();
    display.setFont(u8g2_font_ncenB10_tr);
    display.drawStr(0, 20, "WiFi Baglandi!");
    display.setFont(u8g2_font_ncenB08_tr);
    display.drawStr(0, 45, "IP:");
    display.drawStr(25, 45, WiFi.localIP().toString().c_str());
    display.sendBuffer();
    delay(2000);
}

void showVisitorCount() {
    if (!displayOK) return;
    display.clearBuffer();
    
    // Başlık
    display.setFont(u8g2_font_ncenB08_tr);
    display.drawStr(0, 10, "alienes.me");
    display.drawStr(75, 10, currentDate.c_str());
    
    // Üst çizgi
    display.drawHLine(0, 14, 128);
    
    // Günlük ziyaretçi (büyük)
    display.setFont(u8g2_font_ncenB18_tr);
    char countStr[10];
    sprintf(countStr, "%d", visitorCount);
    int width = display.getStrWidth(countStr);
    display.drawStr((128 - width) / 2, 38, countStr);
    
    // Günlük yazısı
    display.setFont(u8g2_font_ncenB08_tr);
    display.drawStr(30, 48, "Gunluk Ziyaretci");
    
    // Alt çizgi
    display.drawHLine(0, 51, 128);
    
    // Anlık ziyaretçi (alt kısım)
    display.setFont(u8g2_font_ncenB10_tr);
    char activeStr[20];
    sprintf(activeStr, "Anlik: %d", activeVisitors);
    int activeWidth = display.getStrWidth(activeStr);
    display.drawStr((128 - activeWidth) / 2, 63, activeStr);
    
    display.sendBuffer();
}

void showError(const char* message) {
    if (!displayOK) return;
    display.clearBuffer();
    display.setFont(u8g2_font_ncenB10_tr);
    display.drawStr(0, 15, "HATA:");
    display.setFont(u8g2_font_ncenB08_tr);
    display.drawStr(0, 35, message);
    display.sendBuffer();
}

void connectWiFi() {
    Serial.print("WiFi'ye baglaniliyor: ");
    Serial.println("(auto-select)");
    showConnecting();
    
    WiFi.mode(WIFI_STA);
    WiFi.disconnect();
    delay(100);
    
    // Ağları tara
    int n = WiFi.scanNetworks();
    Serial.print("Bulunan ag sayisi: ");
    Serial.println(n);
    bool triedAny = false;
    int attempts = 0;
    
    // Tercihli SSID'ler arasında en uygun olanını seç
    String chosenSsid = "";
    String chosenPass = "";
    
    for (int i = 0; i < n; i++) {
        String thisSsid = WiFi.SSID(i);
        for (int k = 0; k < KNOWN_SSID_COUNT; k++) {
            if (thisSsid == String(knownSsids[k])) {
                chosenSsid = thisSsid;
                chosenPass = String(knownPasswords[k]);
                break;
            }
        }
        if (chosenSsid.length() > 0) break;
    }

    if (chosenSsid.length() == 0) {
        // Eğer bulunamadıysa, ilk bilinen ağ ile dene
        chosenSsid = String(knownSsids[0]);
        chosenPass = String(knownPasswords[0]);
    }

    Serial.print("Secilen SSID: ");
    Serial.println(chosenSsid);
    Serial.print("Secilen sifre: ");
    Serial.println(chosenPass);
    
    WiFi.begin(chosenSsid.c_str(), chosenPass.c_str());
    while (WiFi.status() != WL_CONNECTED && attempts < 30) {
        delay(500);
        Serial.print(".");
        attempts++;
    }
    
    if (WiFi.status() == WL_CONNECTED) {
        Serial.println();
        Serial.print("Baglandi! IP: ");
        Serial.println(WiFi.localIP());
        // Print WiFi status and MAC to help debugging
        Serial.print("WiFi status: ");
        Serial.println(wifiStatusToString(WiFi.status()));
        Serial.print("ESP32 MAC: ");
        Serial.println(WiFi.macAddress());
        showWiFiConnected();
    } else {
        Serial.println();
        Serial.println("WiFi baglantisi basarisiz!");
        Serial.print("WiFi status: ");
        Serial.println(wifiStatusToString(WiFi.status()));
        showError("WiFi hatasi");
    }
}

void fetchVisitorCount() {
    if (WiFi.status() != WL_CONNECTED) {
        connectWiFi();
        return;
    }
    
    Serial.println("Ziyaretci sayisi aliniyor...");
    
    WiFiClientSecure client;
    client.setInsecure();
    
    HTTPClient http;
    http.begin(client, apiUrl);
    http.setTimeout(10000);
    
    int httpCode = http.GET();
    
    if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        Serial.print("Yanit: ");
        Serial.println(payload);
        
        DynamicJsonDocument doc(1024);
        DeserializationError err = deserializeJson(doc, payload);
        if (!err) {
            visitorCount = doc["count"].as<int>();
            activeVisitors = doc["active"].as<int>();
            currentDate = doc["date"].as<String>();
            
            Serial.print("Gunluk: ");
            Serial.print(visitorCount);
            Serial.print(" | Anlik: ");
            Serial.println(activeVisitors);
            
            showVisitorCount();
            
            // Sadece ziyaretçi sayısı değiştiğinde veritabanına kaydet
            if (visitorCount != lastLoggedCount) {
                Serial.println("Ziyaretci sayisi degisti, veritabanina kaydediliyor...");
                logToDatabase(visitorCount);
            }
        }
    }
    http.end();
}

// Veritabanına ziyaretçi sayısını kaydet
void logToDatabase(int count) {
    if (WiFi.status() != WL_CONNECTED) {
        return;
    }
    
    WiFiClientSecure client;
    client.setInsecure();
    
    HTTPClient http;
    http.begin(client, logApiUrl);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    http.setTimeout(5000);
    
    String postData = "count=" + String(count) + "&token=" + String(ESP32_TOKEN);
    
    int httpCode = http.POST(postData);
    
    if (httpCode == HTTP_CODE_OK) {
        String response = http.getString();
        Serial.print("Log kaydedildi: ");
        Serial.println(response);
        lastLoggedCount = count;
    } else {
        Serial.print("Log hatasi: ");
        Serial.println(httpCode);
    }
    
    http.end();
}

void setup() {
    Serial.begin(115200);
    delay(1000);
    Serial.println("\n=== ESP32 Ziyaretci Sayaci v2.0 ===");
    
    initDisplay();
    connectWiFi();
    
    if (WiFi.status() == WL_CONNECTED) {
        fetchVisitorCount();
    }
}

void loop() {
    if (millis() - lastUpdate >= UPDATE_INTERVAL) {
        lastUpdate = millis();
        fetchVisitorCount();
    }
    
    if (WiFi.status() != WL_CONNECTED) {
        connectWiFi();
        if (WiFi.status() == WL_CONNECTED) {
            fetchVisitorCount();
        }
    }
    
    // 1 saniye güncelleme aralığı olduğu için delay kaldırıldı
    delay(100); // Küçük gecikme CPU kullanımını düşürür
}
