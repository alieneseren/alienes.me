## 2024-05-14 - [Generated File Management]
**Learning:** `npm run build` ve `composer install` çalıştırıldığında `package-lock.json`, `storage/framework/views/` ve `storage/logs/` altında framework tarafından üretilen geçici dosyalar git değişiklikleri arasına (staging area) girebilir.
**Action:** `git add .` komutu kullanmak yerine sadece ilgili değişiklik yapılan dosyaları `git add` ile git'e dahil et, eğer tümü eklendiyse commit öncesi `git restore --staged` komutu ile geçici dosyaları geri al.
