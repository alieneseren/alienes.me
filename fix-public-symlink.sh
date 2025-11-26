#!/bin/bash

echo "==================================="
echo "Public Symlink Düzeltme Script"
echo "==================================="

# public klasörünün mevcut durumunu kontrol et
if [ -L "public" ]; then
    echo "✓ 'public' zaten bir symlink"
    LINK_TARGET=$(readlink public)
    echo "  Hedef: $LINK_TARGET"
    
    if [ "$LINK_TARGET" != "public_html" ]; then
        echo "⚠ Symlink yanlış hedefe işaret ediyor, düzeltiliyor..."
        rm public
        ln -s public_html public
        echo "✓ Symlink public_html'e yönlendirildi"
    fi
elif [ -d "public" ]; then
    echo "⚠ 'public' bir klasör, symlink'e dönüştürülüyor..."
    
    # Public içeriğini public_html'e kopyala (Overwrite)
    echo "  Dosyalar public_html'e senkronize ediliyor..."
    cp -r public/* public_html/
    echo "  ✓ Dosyalar kopyalandı"
    
    # public klasörünü yedekle ve sil
    mv public public_backup_$(date +%Y%m%d_%H%M%S)
    
    # Symlink oluştur
    ln -s public_html public
    echo "✓ Symlink oluşturuldu (eski klasör yedeklendi)"
else
    echo "⚠ 'public' klasörü bulunamadı, oluşturuluyor..."
    ln -s public_html public
    echo "✓ Symlink oluşturuldu"
fi

# public_html/build klasörünün izinlerini kontrol et
if [ -d "public_html/build" ]; then
    echo ""
    echo "Build klasörü izinleri ayarlanıyor..."
    chmod -R 755 public_html/build
    echo "✓ İzinler ayarlandı"
    
    echo ""
    echo "Build klasörü içeriği:"
    ls -la public_html/build/
else
    echo ""
    echo "⚠ public_html/build klasörü bulunamadı!"
    echo "  Local makineden build dosyalarını yüklemeniz gerekiyor."
fi

echo ""
echo "✓ İşlem tamamlandı!"
echo ""
echo "Sonraki adımlar:"
echo "1. View cache'ini temizleyin: php artisan view:clear"
echo "2. Config cache'ini yenileyin: php artisan config:cache"
echo "3. Tarayıcı cache'ini temizleyip siteyi kontrol edin"
