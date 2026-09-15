
## 2025-02-23 - Görünüm (View) Dosyalarında Performans Optimizasyonu
**Learning:** `count() > 0` kullanmak veritabanında tüm tabloyu saymaya (full table scan vari bir işlem) yol açarak performansı düşürür, özellikle layout dosyalarında her sayfa yüklenişinde. Model koleksiyonları yüklendikten sonra `count() > 0` kullanmak ise in-memory gereksiz bir işlemdir.
**Action:** Sadece varlık (existence) kontrolü yapmak gerekiyorsa `exists()` kullanılmalıdır. Hafızaya alınmış (loaded) bir koleksiyon üzerinden işlem yapılıyorsa okunabilirliği artırmak ve hızlandırmak için `isNotEmpty()` tercih edilmelidir. Aksi takdirde sunucu yükü boşa artar.

## 2025-02-23 - Derlenmiş Şablonların (Compiled Views) Yönetimi
**Learning:** `storage/framework/views/` altındaki `.php` dosyaları otomatik üretilen (generated/compiled) önbellek (cache) dosyalarıdır ve `git status` ile takibe alınmamalıdır.
**Action:** Bu tür doğrulamalar yaptıktan sonra değişiklikleri commit etmeden önce kesinlikle `git clean -fd storage/framework/views/` komutu kullanılmalı ve yanlışlıkla stage'e eklendilerse `git restore --staged storage/framework/views/` ile geri alınmalıdır. `package-lock.json` dosyası da asla izinsiz değiştirilmemelidir.
