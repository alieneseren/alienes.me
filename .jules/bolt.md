
## 2024-06-18 - Git Index.lock Sorunu
**Learning:** Eğer git işlemlerinde (örneğin stage'den dosya çıkarırken) ".git/index.lock" hatası alınıyorsa, arka planda asılı kalmış bir işlem olabilir.
**Action:** Bu durumda manuel olarak `rm -f /app/.git/index.lock` komutunu kullanarak dosyayı silmek ve işleme devam etmek en hızlı çözümdür.
