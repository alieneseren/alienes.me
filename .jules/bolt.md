
## 2024-05-24 - Model::count() vs Model::exists() in Blade Views
**Learning:** Blade şablonlarında bir tablonun boş olup olmadığını kontrol ederken (örneğin layout koşullarında `\App\Models\Experience::count() > 0`), veritabanında `SELECT COUNT(*)` çalıştırdığı için büyük tablolarda gereksiz yük oluşturur. Koleksiyonlarda ise (ör. in-memory resultset) `$collection->count() > 0` yöntemi ufak çaplı bir bellek/işlem yükü getirir.
**Action:** Veritabanı sorgusu olarak sadece varlık kontrolü isteniyorsa daima `Model::exists()` kullanılmalıdır. Bu sayede `SELECT 1 LIMIT 1` sorgusu çalışır ve eşleşme bulunduğunda tarama sonlanır. Bellekteki koleksiyonlarda (in-memory) varlık kontrolü için ise okunabilirliği ve verimliliği artıran `$collection->isNotEmpty()` kullanılmalıdır.
