
## 2024-03-14 - Blade Görünümlerinde Performans Artışı
**Learning:** Laravel Blade içerisinde in-memory collections kontrol edilirken `count() > 0` yerine `isNotEmpty()` metodunun kullanılması gereksiz sayım işlemlerini önler. Ayrıca veritabanından veri varlığını statik olarak kontrol ederken `count() > 0` kullanmak tüm satırları saymaya (ve ağır `SELECT COUNT(*)` sorgularına) yol açarken, `exists()` kullanmak `LIMIT 1` sayesinde çok büyük bir performans artışı sağlar.
**Action:** İleriki işlerde, veri varlığını kontrol eden yerlerde, koleksiyonlar için `isNotEmpty()` ve Eloquent/Query Builder modelleri için `exists()` metodunu tercih etmeye devam et.
