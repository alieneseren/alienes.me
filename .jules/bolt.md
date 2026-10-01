
## 2025-02-18 - N+1 Optimizasyonu (SitemapController)
**Learning:** SitemapController gibi listeleme döngülerinde (sitemap XML üretimi vb.) ilişkili modeller (category) çağrılırken Eager Loading kullanılmaması gereksiz yere her eleman için ayrı veritabanı sorgusu üretir.
**Action:** Tüm listeleme ve döngü operasyonlarında, döngü içerisinde ilişkili modellere erişiliyorsa ilgili sorguda `with()` metodu ile Eager Loading kullanılmalı.
