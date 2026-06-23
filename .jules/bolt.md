
## 2025-06-23 - Homepage Cache Invalidation Pattern
**Learning:** Ana sayfa verilerini önbelleğe alırken, Laravel'in AppServiceProvider içindeki `Profile::saved` veya `$clearHomeCollections` gibi ortak event listener'lar sayesinde, veritabanına giden 5 farklı gereksiz N+1 benzeri sorguyu önleyebiliriz. Ana sayfa cache'inin paginasyon olmayan koleksiyonlara (`home_collections.data`) uygulanması daha etkilidir.
**Action:** İleriye dönük benzer ana sayfa veya dashboard sayfalarında toplu veriyi array olarak tek cache key altında tutup, AppServiceProvider üzerinden tek merkezden temizlemek.
