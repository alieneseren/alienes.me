## 2025-02-09 - Blade Koleksiyon Optimizasyonu ve exists()
**Learning:** Layout ve ana sayfa görünümlerinde önbelleğe alınmış ya da sorgulanmış koleksiyonlar üzerinde `$collection->count() > 0` kullanmak hem gereksiz hafıza yükü oluşturuyor hem de sorguyu saymaya zorluyor. Bunun yerine veritabanı aşamasında `exists()` metodu, koleksiyon aşamasında ise `isNotEmpty()` kullanmak performansı mikro seviyede de olsa artırır ve okunabilirliği güçlendirir.
**Action:** `count() > 0` gördüğün yerlerde bağlama (context) göre Eloquent için `exists()`, Collections için `isNotEmpty()` kullan.
