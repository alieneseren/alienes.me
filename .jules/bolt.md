## 2025-02-12 - Blade Şablonlarında count() yerine exists() Kullanımı
**Learning:** Laravel Blade şablonlarında tabloların doluluğunu kontrol ederken `Model::count() > 0` kullanmak, tüm tabloyu saymak için `COUNT(*)` sorgusu oluşturarak gereksiz veritabanı yükü yaratır.
**Action:** Bu tür veritabanı sayım kontrolleri yerine daima `Model::exists()` kullanarak sorgunun `LIMIT 1` ile sınırlandırılmasını ve daha hızlı dönmesini sağlamalıyız. Ayrıca halihazırda belleğe yüklenmiş Eloquent koleksiyonları için `count() > 0` yerine `isNotEmpty()` kullanılmalıdır.
