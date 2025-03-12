# Approval App

Approval App adalah aplikasi berbasis Laravel 11 yang digunakan untuk mengelola proses persetujuan pengeluaran.

## Persyaratan

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL atau database lain yang didukung oleh Laravel

## Instalasi

1. Clone repository ini:

    ```bash
    git clone https://github.com/hidesec/approval-app.git
    cd approval-app
    ```

2. Install dependensi PHP dengan Composer:

    ```bash
    composer install
    ```

3. Install dependensi JavaScript dengan npm:

    ```bash
    npm install
    ```

4. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:

    ```bash
    cp .env.example .env
    ```

5. Generate application key:

    ```bash
    php artisan key:generate
    ```

6. Migrasi dan seed database:

    ```bash
    php artisan migrate --seed
    ```

## Menjalankan Aplikasi

1. Jalankan server pengembangan Laravel:

    ```bash
    php artisan serve
    ```

Aplikasi sekarang dapat diakses di `http://localhost:8000`.

## Testing

Untuk menjalankan test, gunakan perintah berikut:

```bash
php artisan test
