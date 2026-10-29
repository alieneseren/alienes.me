
## 2024-10-29 - Veritabanı Varoluş Kontrolü ve Null Birleştirme
**Learning:** Blade şablonlarında \App\Models\Model::count() > 0 yerine \App\Models\Model::exists() kullanmak ve controller tarafından geçilen model değişkenlerini `??` ile kontrol etmek, gereksiz ve ağır veritabanı sorgularını önler (count yerine limit 1 kullanır).
**Action:** Her zaman `exists()` fonksiyonunu kullan ve değişkenlerin önceden geçilip geçilmediğini kontrol et.
