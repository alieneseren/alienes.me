
## 2025-02-18 - Blade Şablonlarında Model Varlığı Kontrolü Optimizasyonu
**Learning:** `count() > 0` kullanımı `SELECT COUNT(*)` sorgusu çalıştırırken `exists()` kullanıldığında Laravel `SELECT EXISTS(...)` veya `SELECT 1 ... LIMIT 1` sorgusuna çevirir. Bu, aranan tablo boyutları büyüdüğünde ciddi bir okuma ve tarama performansı farkı yaratır. Görünüm (blade) dosyalarındaki global değişken atamalarında bu gibi küçük query optimizasyonları toplu halde sayfa yükleme süresini ve DB yükünü düşürür.
**Action:** Modelin sadece herhangi bir kaydının olup olmadığını denetlemek gerektiği her durumda `count() > 0` yerine mutlaka `exists()` kullanacağım.
