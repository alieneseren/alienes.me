#!/bin/bash

# Configuration
HOST="147.93.92.23"
USER="u233064020"
PORT="65002"
REMOTE_BASE="/home/u233064020/domains/alienes.me"
REMOTE_TARGET="$REMOTE_BASE/public/balina"
LOCAL_DIR="woa-visualizer"
ZIP_FILE="woa_deploy.zip"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${YELLOW}🚀 Starting WOA Visualizer Deployment...${NC}"

# 1. Build
echo -e "${GREEN}📦 Building project...${NC}"
cd $LOCAL_DIR
npm install
npm run build
if [ $? -ne 0 ]; then
    echo -e "${RED}❌ Build failed!${NC}"
    exit 1
fi
cd ..

# 2. Package
echo -e "${GREEN}🗜️  Packaging...${NC}"
rm -f $ZIP_FILE
cd $LOCAL_DIR/dist
zip -r ../../$ZIP_FILE .
cd ../..

# 3. Upload and Deploy
echo -e "${GREEN}📤 Uploading to server...${NC}"
echo -e "${YELLOW}⚠️  You will be prompted for the SSH password.${NC}"

# Upload zip
scp -P $PORT $ZIP_FILE $USER@$HOST:$REMOTE_BASE/

# Execute remote commands
echo -e "${GREEN}🔧 Extracting on server...${NC}"
echo -e "${YELLOW}⚠️  You will be prompted for the SSH password again.${NC}"

ssh -p $PORT $USER@$HOST << EOF
    # Create target directory if it doesn't exist
    mkdir -p $REMOTE_TARGET
    
    # Clean old files
    rm -rf $REMOTE_TARGET/*
    
    # Unzip new files
    unzip -o $REMOTE_BASE/$ZIP_FILE -d $REMOTE_TARGET
    
    # Remove zip
    rm $REMOTE_BASE/$ZIP_FILE
    
    echo "✅ Remote setup complete."
EOF

# Cleanup local
rm -f $ZIP_FILE

echo -e "${GREEN}✨ Deployment finished! Visit: https://balina.alienes.me${NC}"
