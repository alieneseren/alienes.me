## 2024-11-11 - Layout İçi Sorgu Optimizasyonları
**Öğrenim:** Blade layout dosyalarındaki (örneğin frontend.blade.php) `count() > 0` kontrolleri ve tekrarlanan inline sorgular (örneğin, navigasyon için `Cv::exists()`) gereksiz N+1 benzeri fazladan sorgu yüküne yol açar.
**Aksiyon:** Her zaman Controller'dan gelen değişkenleri tekrar kullanın (`$profile = $profile ?? ...`). Varoluş kontrolleri için `count() > 0` yerine `exists()` kullanın ve tekrarlanan aynı veritabanı sorgularını `@php` bloğunda tek bir değişkene atayarak çoklu kullanımı optimize edin.
