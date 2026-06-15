## 2025-02-09 - HomeController Cache Optimization
**Learning:** Ana sayfadaki (`HomeController::index`) çoklu veritabanı sorguları (`Profile`, `Experience`, `Education`, `Skill`, `Project`) nadiren değişen verilerdir. Bu modelleri her sayfa ziyaretinde ayrı ayrı sorgulamak gereksiz bir darboğaz yaratıyordu.
**Action:** `Cache::rememberForever` kullanarak bu verileri önbelleğe aldım ve ilgili modeller kaydedildiğinde (saved) veya silindiğinde (deleted) `AppServiceProvider` üzerinden cache'i temizleyerek stale data sorununu çözdüm. Bu sayede ana sayfa yükleme süresi hızlandırılmış oldu.
