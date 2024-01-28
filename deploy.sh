#!/bin/bash

# Ambil kode terbaru dari GitHub
git pull origin master

# Install dependensi PHP
composer install

# Menjalankan migrasi database jika diperlukan
#php artisan migrate

# Menyalin file konfigurasi
cp .env. .env

# Menjalankan perintah Laravel lainnya sesuai kebutuhan

# Upload ke server FTP
lftp -u furnixfu , Furnix@123 -e "mirror -R ./api.furnixfurniture.co.id ; quit" ftp.furnixfurniture.co.id
