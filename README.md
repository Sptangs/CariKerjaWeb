<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Docker

### Development

1. Salin `.env.example` menjadi `.env`, lalu isi `DB_PASSWORD` dan `MYSQL_ROOT_PASSWORD`.
2. Build dan jalankan:

   ```bash
   docker compose build
   docker compose up -d
   ```

3. Aplikasi: `http://localhost:8000`, phpMyAdmin: `http://127.0.0.1:8080`, MySQL dari host: `127.0.0.1:3307`.
4. Jika `APP_KEY` masih kosong (`.env` di-bind mount, jadi hasilnya tersimpan di host):

   ```bash
   docker compose exec app php artisan key:generate
   ```

5. Migrasi otomatis berjalan jika `RUN_MIGRATIONS=true`. Untuk mengisi data contoh:

   ```bash
   docker compose exec app php artisan db:seed
   ```

### Refresh volume vendor dan build

Named volume `vendor` dan `build` di-seed dari image saat pertama kali dibuat. Perubahan pada `composer.json` / `composer.lock` atau dependency frontend tidak otomatis masuk ke volume tersebut.

Setelah mengubah dependency, build ulang lalu ganti volume:

```bash
docker compose build --no-cache app
docker compose down
docker volume rm carikerja_vendor carikerja_build
docker compose up -d
```

Peringatan: `docker compose down -v` juga menghapus volume database. Hapus volume secara spesifik seperti contoh di atas jika data database ingin dipertahankan.

### Production

1. Salin `.env.production.example` menjadi `.env` di server, lalu isi `APP_KEY`, kredensial database, dan `APP_URL`. Karena production tidak memakai bind mount, generate `APP_KEY` di host dengan `php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"` lalu salin nilainya ke `.env`.
2. Build dan jalankan:

   ```bash
   docker compose -f docker-compose.prod.yml build
   docker compose -f docker-compose.prod.yml up -d
   ```

3. Jalankan migrasi secara eksplisit (default `RUN_MIGRATIONS=false`):

   ```bash
   docker compose -f docker-compose.prod.yml exec app php artisan migrate --force
   ```

4. HTTPS dan reverse proxy (mis. Caddy, Traefik, atau Nginx di host) belum termasuk dan perlu disiapkan terpisah.
