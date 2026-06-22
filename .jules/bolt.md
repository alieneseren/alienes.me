## 2024-10-26 - Cache Pagination DoS Vulnerability
**Learning:** Kullanıcı girdisine bağlı önbellekleme yaparken (örn. sayfalama sayfası), doğrulanmamış girdiler `Cache::rememberForever` ile kullanıldığında cache exhaustion (önbellek şişmesi/DoS) güvenlik açığı oluşturur.
**Action:** Kullanıcıdan gelen parametrelere (page) bağlı önbellek anahtarları oluştururken her zaman veriyi doğrula (örneğin `filter_var` ile tamsayı kontrolü yap) ve sonsuz önbellekleme yerine bir TTL (örn. `remember` ile 1 gün) kullanarak disk dolmasını engelle.
