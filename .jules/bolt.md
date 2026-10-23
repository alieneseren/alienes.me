## 2023-10-24 - Layout Sorgu Optimizasyonu
**Learning:** Blade view'lerinde `count() > 0` kullanmak veritabanında gereksiz bir tablo sayımı işlemine neden oluyor ve N+1 sorununu büyütüyor.
**Action:** `count() > 0` yerine `exists()` kullanılarak sorgu `LIMIT 1` olarak optimize edilebilir ve performans iyileştirilebilir.
