// ESP32 Visitor Counter - Configuration
// Modify these values for your setup

#ifndef CONFIG_H
#define CONFIG_H

// ============== WiFi Settings ==============
#define WIFI_SSID "WIFI_ADINIZ"
#define WIFI_PASSWORD "WIFI_SIFRENIZ"

// ============== API Settings ==============
#define API_BASE_URL "https://alienes.me"
#define API_VISITOR_COUNT "/api/visitor-count"
#define API_VISITOR_SIMPLE "/api/visitor-count/simple"

// ============== Update Interval ==============
// How often to fetch visitor count (in milliseconds)
#define UPDATE_INTERVAL_MS 60000  // 1 minute

// ============== Display Settings ==============
#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_I2C_ADDRESS 0x3C
#define OLED_RESET_PIN -1

// ============== I2C Pins ==============
// Default ESP32 I2C pins
#define I2C_SDA 21
#define I2C_SCL 22

// ============== Debug Settings ==============
#define SERIAL_BAUD_RATE 115200
#define ENABLE_SERIAL_DEBUG true

#endif // CONFIG_H
