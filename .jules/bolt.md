## 2024-05-18 - Blade Şablonlarında count() yerine exists() Kullanımı
**Learning:** Laravel Blade şablonlarında koşullu blokları render ederken veritabanından veri varlığını kontrol etmek için `count() > 0` kullanmak, tüm tablo satırlarının sayılmasını gerektiren tam bir tablo taramasına (`SELECT COUNT(*)`) neden olabilir.
**Action:** `exists()` metodunu kullanarak bu sorguları bir varlık kontrolüne (`SELECT 1 ... LIMIT 1`) dönüştürün. Bu, özellikle büyük tablolarda veritabanı yükünü önemli ölçüde azaltır ve uygulama performansını artırır.
