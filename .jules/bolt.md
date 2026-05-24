## 2026-05-24 - Homepage Data Caching
**Learning:** Ana sayfadaki tüm modelleri (Profile, Experience, vb.) her istekte veritabanından çekmek performans kaybına neden oluyor. Bu verileri 'home.data' anahtarıyla önbelleğe almak ve AppServiceProvider'da model olayları (saved/deleted) ile önbelleği temizlemek, uygulamanın hızını önemli ölçüde artırır.
**Action:** Sık ziyaret edilen sayfalardaki (ana sayfa gibi) statik/nadiren değişen verileri her zaman Cache::rememberForever ile önbelleğe al ve model olaylarını kullanarak önbellek temizliğini (invalidation) garanti altına al.
