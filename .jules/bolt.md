## 2024-05-16 - [Frontend Blade Dosyalarında Eloquent count() Optimizasyonu]
**Learning:** Blade şablonlarında varlık kontrolü için `count() > 0` kullanmak, tüm tabloyu `SELECT COUNT(*)` ile saydığı için performans sorunlarına yol açabilir. Laravel'de bunun yerine `exists()` kullanmak `SELECT 1 ... LIMIT 1` sorgusu üreterek performansı çok büyük ölçüde artırır.
**Action:** Varlık/yokluk kontrollerinde her zaman `count()` yerine `exists()` kullanılması gerektiğine dikkat edeceğim.
