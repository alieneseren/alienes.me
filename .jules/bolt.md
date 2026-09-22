
## 2024-05-20 - Laravel Blade Koleksiyon ve Veritabanı Sorgu Optimizasyonu
**Learning:** Laravel'de `count() > 0` kullanmak, koleksiyonlarda tüm öğeleri döner ve hafıza tüketimini artırırken veritabanında `COUNT(*)` sorgusu çalıştırarak tablo taramasına sebep olur.
**Action:** Koleksiyonlarda `count() > 0` yerine `isNotEmpty()` metodunu, veritabanı sorgularında ise `LIMIT 1` ile `EXISTS` sorgusu üreten `exists()` metodunu kullanarak performansı artırdım.
