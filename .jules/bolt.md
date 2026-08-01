## 2025-02-12 - Layout Dosyalarında Önbellekleme
**Learning:** `frontend.blade.php` gibi temel layout dosyalarında menü oluşturmak veya koşullu alanları (CV, projeler vb.) göstermek için yapılan mükerrer `count() > 0` ve `exists()` sorguları, her sayfa yüklenmesinde gereksiz bir veritabanı yükü yaratır.
**Action:** Bu tür layout düzeyindeki tüm statik/yarı statik koşul kontrollerini tek bir `Cache::remember` bloğu içine alarak, sorgu sayısını N'den (her tablo için 1) 0'a (önbellekten okuma) indirmeliyiz.
