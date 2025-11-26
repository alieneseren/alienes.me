# FILE MANAGER KULLANARAK BUILD DOSYALARINI YÜKLEME

## Sorun Nedir?
Laravel, Vite manifest dosyasını `/home/u233064020/domains/alienes.me/public/build/manifest.json` konumunda arıyor ama dosya muhtemelen `public_html/build/` içinde.

## Çözüm 1: File Manager Üzerinden Yükleme

### Adım 1: Local Build Dosyalarını Hazırlayın
Local makinenizdeki bu dosyalar:
```
/Users/alienes/alienes.me/public/build/manifest.json
/Users/alienes/alienes.me/public/build/assets/app-ddec999e.css
/Users/alienes/alienes.me/public/build/assets/app-5bdafbf3.js
```

### Adım 2: Hostinger File Manager'da Klasör Oluşturun
1. Hostinger Control Panel > File Manager'a gidin
2. `/domains/alienes.me/public_html/` dizinine gidin
3. Eğer `build` klasörü yoksa oluşturun
4. `build` klasörü içinde `assets` klasörü oluşturun

### Adım 3: Dosyaları Yükleyin
1. `manifest.json` dosyasını `public_html/build/` içine yükleyin
2. CSS ve JS dosyalarını `public_html/build/assets/` içine yükleyin

### Adım 4: İzinleri Kontrol Edin
File Manager'da:
- `build` klasörüne sağ tıklayın > Permissions > 755 seçin
- `assets` klasörüne sağ tıklayın > Permissions > 755 seçin
- Her dosyaya 644 izni verin

### Adım 5: SSH'de Cache Temizleyin
```bash
ssh -p 65002 u233064020@147.93.92.23
cd /home/u233064020/domains/alienes.me
php artisan view:clear
php artisan config:cache
exit
```

## Çözüm 2: SSH ile Symlink Düzeltme (ÖNERİLEN)

Eğer `public` klasörü bir symlink değilse, Laravel yanlış yere bakıyordur.

### SSH'de çalıştırın:
```bash
ssh -p 65002 u233064020@147.93.92.23

cd /home/u233064020/domains/alienes.me

# Mevcut durumu kontrol et
ls -la | grep public

# Eğer public bir KLASÖR ise (symlink değil):
# 1. Build dosyalarını kopyala
mkdir -p public_html/build
if [ -d "public/build" ]; then cp -r public/build/* public_html/build/; fi

# 2. public'i yedekle ve symlink oluştur
mv public public_backup
ln -s public_html public

# 3. İzinleri düzelt
chmod -R 755 public_html/build

# 4. Cache'leri temizle
php artisan view:clear
php artisan config:cache

# 5. Kontrol et
ls -la public/build/
# manifest.json görmelisiniz

exit
```

## Çözüm 3: Vite Config'i Değiştir (Geçici)

Eğer yukarıdakiler çalışmazsa, manifest.json'ı public_html içinde tutun:

### config/vite.php dosyasını düzenleyin:
```php
'build_path' => env('VITE_BUILD_PATH', 'build'),
```

Bu değişiklikten sonra:
```bash
php artisan config:clear
php artisan config:cache
```

## Doğrulama

Tarayıcıda şu URL'leri test edin:
- https://alienes.me/build/manifest.json (dosyayı görmeli)
- https://alienes.me/build/assets/app-ddec999e.css (CSS'i görmeli)

Eğer 404 alıyorsanız, dosyalar yanlış yerde veya izinler hatalı.

## Son Kontrol Listesi

✓ manifest.json `/home/u233064020/domains/alienes.me/public_html/build/` içinde mi?
✓ assets klasörü ve dosyaları var mı?
✓ Dosya izinleri 644, klasör izinleri 755 mi?
✓ public symlink doğru mu? (`ls -la | grep public` ile kontrol edin)
✓ Cache'ler temizlendi mi? (`php artisan view:clear`)
✓ Tarayıcıda manifest.json dosyasına erişebiliyor musunuz?

Hala hata alıyorsanız, şu komutu çalıştırın ve çıktıyı gönderin:
```bash
ls -la /home/u233064020/domains/alienes.me/ | grep public
ls -la /home/u233064020/domains/alienes.me/public_html/build/
cat /home/u233064020/domains/alienes.me/public_html/build/manifest.json
```
