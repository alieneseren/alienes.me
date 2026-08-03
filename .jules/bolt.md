## 2025-02-12 - Layout Veri Önbellekleme
**Learning:** Laravel şablonlarında (örneğin layout dosyalarında) sayfa yüklendiğinde tekrar eden statik veritabanı sayımları ve model çekimleri (`count()`, `first()`), küçük gecikmelere sebep olabilir.
**Action:** Bu tür layout bağımlı statik verileri tek bir Cache bloğunda birleştirmek ve sayım işlemlerini `exists()` ile optimize etmek veritabanı sorgularını önemli ölçüde azaltır.
