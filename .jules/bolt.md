## 2024-04-03 - [Ana Sayfa Önbellekleme]
**Learning:** Uygulamanın anasayfasında sıklıkla değişmeyen (Profil, Deneyim, Eğitim, Yetenek, Projeler) gibi bilgilerin her sayfa yüklenmesinde ayrı ayrı 5 veritabanı sorgusu ile çekildiği fark edildi.
**Action:** `Cache::rememberForever` ile veritabanı sorgularının önbelleğe alınması sağlandı ve `ClearsHomePageCache` trait'i ile veri güncellendiğinde/silindiğinde stale data olmaması için cache'in temizlenmesi sağlandı.
