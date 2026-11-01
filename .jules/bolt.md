## 2024-11-01 - [Layout İçi Sorguların Optimizasyonu]
**Learning:** Layout dosyalarında inline yapılan `count() > 0` gibi kontroller, her sayfa yüklendiğinde tüm tablonun sayılmasına neden olur. Bu veritabanı performansını olumsuz etkiler.
**Action:** Layout dosyalarında varlık kontrolü yaparken `count() > 0` yerine `exists()` kullanmak ve Controller tarafından aktarılan değişkenleri (örneğin `$profile = $profile ?? \App\Models\Profile::first();`) null coalescing operatörü ile yeniden kullanmak sorgu sürelerini ciddi oranda düşürür.
