## 2024-05-11 - Database Query Caching Optimization
**Learning:** Ana sayfa gibi yüksek trafikli sayfalarda yapılan birden fazla veritabanı sorgusunu önbelleğe almak büyük bir performans artışı sağlar, ancak stale verileri (eski verileri) engellemek için AppServiceProvider boot() metodu içinde model olayları dinlenmeli (saved ve deleted) ve cache invalidate edilmelidir.
**Action:** İleride benzer çoklu veritabanı sorguları olan yüksek trafikli sayfalarda bu yöntemi kullan.
