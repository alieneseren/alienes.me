<?php
/**
 * Hostinger'da çalıştırılacak deployment script
 * URL: https://alienes.me/deploy-games.php
 */

// Güvenlik kontrolü
$token = $_GET['token'] ?? '';
$allowed_token = 'deploy_games_2025';

if ($token !== $allowed_token) {
    die('❌ Yetkisiz erişim!');
}

$source = 'games-final.tar.gz';
$extract_dir = './';

if (!file_exists($source)) {
    die("❌ Dosya bulunamadı: $source\n");
}

// Extract
echo "📦 TAR dosyası açılıyor...\n";
$cmd = "tar -xzf {$source}";
exec($cmd, $output, $return_code);

if ($return_code === 0) {
    echo "✅ Dosyalar başarıyla çıkartıldı!\n";
    echo "📁 Yapı:\n";
    exec("ls -la games/ 2>/dev/null | head -15", $files);
    foreach ($files as $file) {
        echo "  $file\n";
    }
    
    // TAR dosyasını sil
    unlink($source);
    echo "\n✅ DEPLOYMENT BAŞARILI!\n";
} else {
    echo "❌ Hata: TAR dosyası açılamadı\n";
}
