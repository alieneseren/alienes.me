#!/bin/bash

# Alienes Portfolio - Hostinger ZIP Deployment Script
# Usage: ./deploy-hostinger-full.sh

# Configuration
HOST="147.93.92.23"
USER="u233064020"
PORT="65002"
PATH_REMOTE="/home/u233064020/domains/alienes.me"
ZIP_FILE="deploy_package.zip"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Stop on error
set -e

# Ensure PATH
export PATH=$PATH:/usr/local/bin:/opt/homebrew/bin:/usr/bin:/bin:/usr/sbin:/sbin:/Users/alienes/.nvm/versions/node/v22.19.0/bin

echo -e "${YELLOW}🚀 Starting ZIP deployment to Hostinger...${NC}"

# 1. Build Assets Locally
echo -e "${GREEN}📦 Building assets...${NC}"
npm run build

# 2. Create ZIP Package
echo -e "${GREEN}🗜️  Creating deployment package...${NC}"
# Remove old zip if exists
rm -f $ZIP_FILE

# Zip files excluding heavy/unnecessary folders
zip -r $ZIP_FILE . \
    -x "*.git*" \
    -x "node_modules/*" \
    -x "vendor/*" \
    -x "storage/*.key" \
    -x "storage/logs/*" \
    -x "storage/framework/cache/*" \
    -x "storage/framework/sessions/*" \
    -x "storage/framework/views/*" \
    -x ".env" \
    -x ".env.*" \
    -x "deploy-*.sh" \
    -x "tests/*" \
    -x ".*"

# 3. Upload ZIP
echo -e "${GREEN}Cc  Uploading package to server...${NC}"
scp -P $PORT $ZIP_FILE $USER@$HOST:$PATH_REMOTE/

# 4. Remote Commands (Unzip & Setup)
echo -e "${GREEN}🔧 Running remote commands...${NC}"
ssh -p $PORT $USER@$HOST << EOF
    cd $PATH_REMOTE
    
    echo "📂 Unzipping package..."
    unzip -o $ZIP_FILE
    rm $ZIP_FILE
    
    echo "📦 Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader
    
    echo "🔄 Running migrations..."
    # Remove duplicate migration file if exists (caused errors previously)
    rm -f database/migrations/2025_11_19_143623_create_game_scores_table.php
    
    php artisan migrate --force
    
    echo "🧹 Clearing cache..."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear
    
    echo "⚡ Rebuilding cache..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    echo "🔐 Fixing permissions..."
    chmod -R 755 storage bootstrap/cache
EOF

# Cleanup local zip
rm -f $ZIP_FILE

echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
