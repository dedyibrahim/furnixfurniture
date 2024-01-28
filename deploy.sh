#!/bin/bash

# Ambil kode terbaru dari GitHub
git pull origin master

# Install dependensi PHP
composer install

# Menjalankan migrasi database jika diperlukan
#php artisan migrate

# Menyalin file konfigurasi
cp .env.production .env

# Menjalankan perintah Laravel lainnya sesuai kebutuhan
if ! command -v lftp &> /dev/null; then
    echo "lftp not found. Installing lftp..."
    sudo apt-get update
    sudo apt-get install -y lftp
fi

# Upload ke server FTP
lftp -u furnixfu, Furnix@123 -e "mirror --reverse  ./api.furnixfurniture.co.id/ ; quit" -p 21 ftp.furnixfurniture.co.id
