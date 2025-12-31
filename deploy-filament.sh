#!/bin/bash

# Alienes Portfolio - FilamentPHP Deployment Script
# Laravel 11 + FilamentPHP 3.x güncellemesi için

# Configuration
HOST="147.93.92.23"
USER="u233064020"
PORT="65002"
PATH_REMOTE="/home/u233064020/domains/alienes.me"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${YELLOW}🚀 FilamentPHP Deployment Başlatılıyor...${NC}"
echo ""

# 1. Build Assets
echo -e "${GREEN}📦 1/7 - npm build çalıştırılıyor...${NC}"
npm run build 2>/dev/null || echo "npm build atlandı"

# 2. Sync new app files
echo -e "${GREEN}📁 2/7 - Yeni Filament dosyaları yükleniyor...${NC}"

# Filament klasörü
rsync -avz --progress -e "ssh -p ${PORT}" \
    app/Filament/ \
    ${USER}@${HOST}:${PATH_REMOTE}/app/Filament/

# Yeni modeller
rsync -avz --progress -e "ssh -p ${PORT}" \
    app/Models/Post.php \
    app/Models/Tag.php \
    ${USER}@${HOST}:${PATH_REMOTE}/app/Models/

# GameUploadService
rsync -avz --progress -e "ssh -p ${PORT}" \
    app/Services/GameUploadService.php \
    ${USER}@${HOST}:${PATH_REMOTE}/app/Services/

# User.php (FilamentUser interface)
rsync -avz --progress -e "ssh -p ${PORT}" \
    app/Models/User.php \
    ${USER}@${HOST}:${PATH_REMOTE}/app/Models/

# MigrateLegacyDataCommand
rsync -avz --progress -e "ssh -p ${PORT}" \
    app/Console/Commands/MigrateLegacyDataCommand.php \
    ${USER}@${HOST}:${PATH_REMOTE}/app/Console/Commands/

echo -e "${GREEN}📁 3/7 - Provider dosyaları yükleniyor...${NC}"

# Filament Provider
rsync -avz --progress -e "ssh -p ${PORT}" \
    app/Providers/Filament/ \
    ${USER}@${HOST}:${PATH_REMOTE}/app/Providers/Filament/

echo -e "${GREEN}📁 4/7 - Migration'lar yükleniyor...${NC}"

# Migrations
rsync -avz --progress -e "ssh -p ${PORT}" \
    database/migrations/2025_12_27_000001_expand_blog_posts_table.php \
    database/migrations/2025_12_27_000002_add_zip_fields_to_games_table.php \
    ${USER}@${HOST}:${PATH_REMOTE}/database/migrations/

echo -e "${GREEN}📁 5/7 - View dosyaları yükleniyor...${NC}"

# Views
rsync -avz --progress -e "ssh -p ${PORT}" \
    resources/views/games/ \
    ${USER}@${HOST}:${PATH_REMOTE}/resources/views/games/

rsync -avz --progress -e "ssh -p ${PORT}" \
    resources/views/layouts/frontend.blade.php \
    ${USER}@${HOST}:${PATH_REMOTE}/resources/views/layouts/

# Routes
rsync -avz --progress -e "ssh -p ${PORT}" \
    routes/web.php \
    ${USER}@${HOST}:${PATH_REMOTE}/routes/

echo -e "${GREEN}📁 6/7 - Composer ve Filament assets yükleniyor...${NC}"

# Composer files
rsync -avz --progress -e "ssh -p ${PORT}" \
    composer.json \
    composer.lock \
    ${USER}@${HOST}:${PATH_REMOTE}/

# Filament public assets
rsync -avz --progress -e "ssh -p ${PORT}" \
    public/js/filament/ \
    ${USER}@${HOST}:${PATH_REMOTE}/public_html/js/filament/

rsync -avz --progress -e "ssh -p ${PORT}" \
    public/css/filament/ \
    ${USER}@${HOST}:${PATH_REMOTE}/public_html/css/filament/

echo -e "${GREEN}🔧 7/7 - Sunucuda komutlar çalıştırılıyor...${NC}"

ssh -p ${PORT} ${USER}@${HOST} << 'EOF'
    cd /home/u233064020/domains/alienes.me
    
    echo "📦 Composer update..."
    composer update --no-dev --optimize-autoloader 2>&1 | tail -20
    
    echo ""
    echo "🔄 Migration'lar çalıştırılıyor..."
    php artisan migrate --force
    
    echo ""
    echo "📊 Legacy veri kontrolü..."
    php artisan app:migrate-legacy-data --dry-run
    
    echo ""
    echo "🧹 Cache temizleniyor..."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear
    
    echo ""
    echo "⚡ Cache yeniden oluşturuluyor..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    echo ""
    echo "🎨 Filament optimize ediliyor..."
    php artisan filament:optimize 2>/dev/null || echo "Filament optimize atlandı"
    
    echo ""
    echo "🔐 İzinler düzeltiliyor..."
    chmod -R 755 storage bootstrap/cache
EOF

echo ""
echo -e "${GREEN}✅ Deployment Tamamlandı!${NC}"
echo ""
echo "📌 Kontrol Adresleri:"
echo "   • Admin Panel: https://alienes.me/cp7x9m"
echo "   • Ana Sayfa: https://alienes.me"
echo "   • Oyunlar: https://games.alienes.me"
