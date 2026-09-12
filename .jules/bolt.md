
## 2024-05-18 - Blade Şablonlarında count() yerine exists() Kullanımı
**Learning:** Blade şablonlarında bir veri modelinden kayıt olup olmadığını kontrol etmek için `Model::count() > 0` kullanmak, tüm tabloyu okuyarak performans kaybına yol açar.
**Action:** Her zaman `LIMIT 1` etkisi yaratan `Model::exists()` metodunu kullanarak veri varlığı kontrolünü yapın. Koleksiyonlar için ise okunabilirliği de artıran `isNotEmpty()` metodunu tercih edin.
