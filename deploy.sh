#!/bin/bash

# Ambil kode terbaru dari GitHub
git pull origin master

# Install dependensi PHP
composer install

# Menjalankan migrasi database jika diperlukan
php artisan migrate

# Menyalin file konfigurasi
cp .env.production .env

# Menjalankan perintah Laravel lainnya sesuai kebutuhan
# Ambil nilai dari GitHub Secrets
FTP_USERNAME=${{ secrets.FTP_USERNAME }}
FTP_PASSWORD=${{ secrets.FTP_PASSWORD }}
FTP_HOST= ${{ secrets.FTP_SERVER }}


# Upload ke server FTP
lftp -u "$FTP_USERNAME","$FTP_PASSWORD" -e "mirror -R ./ <REMOTE_PATH> ; quit" "$FTP_HOST"
