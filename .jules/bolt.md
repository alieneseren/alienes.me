
## 2024-05-24 - [N+1 Controller Caching]
**Learning:** Laravel'de controller seviyesinde çoklu model verilerini tek bir cache key'de (home.data) toplamak (5 ayrı query yerine 1 cache hit), AppServiceProvider'da model event'leri (saved/deleted) ile kolayca invalidate edilebilir. Bu sayede hem kod okunaklı kalır hem de ana sayfa gibi trafiği yüksek sayfalarda devasa performans artışı sağlanır.
**Action:** Trafiği yüksek ama nadir güncellenen dashboard/home sayfalarında her model için ayrı cache yerine tüm render verisini tek bir 'aggregate' cache key altında topla ve Service Provider'da ilgili modellerin eventlerini bu cache'i silecek şekilde bağla.
