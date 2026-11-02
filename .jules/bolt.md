
## 2024-11-02 - [Layout Sorgu Optimizasyonu]
**Learning:** Laravel'de controller'da çağrılan değişkenler layout içinde doğrudan tanımlanırsa aynı sorgu tekrar çalışır ve Blade şablonlarında `count() > 0` kullanımı tüm tabloyu saydırarak gereksiz yavaşlamaya neden olur. Aynı sorgular birden fazla yerde çağrıldığında değişkene atamak sorgu sayısını düşürür.
**Action:** Layout dosyalarında model sorguları yaparken Null Coalescing Operator (`$profile ?? Model::first()`) kullanmalı ve varlık kontrollerinde her zaman `exists()` fonksiyonunu tercih etmeliyim. Ayrıca tekrar eden sorguları tek bir değişkene atamalıyım.
