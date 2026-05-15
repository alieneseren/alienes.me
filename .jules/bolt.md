## 2025-05-15 - Laravel Anasayfa Veritabanı Sorguları
**Learning:** Anasayfa gibi sık ziyaret edilen sayfalarda birden fazla modelin (`Profile`, `Experience`, vb.) her istekte veritabanından çekilmesi önemli bir veritabanı yükü oluşturuyor. Ayrıca Laravel'de önbellek temizliği (cache invalidation) için en güvenilir yöntem, bu modellerin `saved` ve `deleted` olaylarına (events) dinleyici eklemektir.
**Action:** Gelecekteki optimizasyonlarda sık okunan ama nadir güncellenen veriler için `Cache::rememberForever` kullanmalı ve ilgili modellerde event tabanlı cache temizliği yapmalıyım.
