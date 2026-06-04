## 2024-06-04 - SQLite Migration Conflicts & Mocking
**Learning:** SQLite'te tabloları sıfırdan kurarken (`migrate:fresh`) duplicate table (örneğin "projects") çakışmaları alınabiliyor. Test amaçlı geçici veritabanı kurmak istendiğinde mevcut migration'lar başarısız olabiliyor.
**Action:** `php artisan migrate:fresh` yerine, test edilecek modeller ve olaylar için `$table->create(...)` yapılarını bizzat test scripti (örn. test_cache.php) içinde tanımlayarak migration'ları bypass etmek daha güvenli.
