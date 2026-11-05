# Evolusi PL — Aplikasi CRUD Item

[![CI](https://github.com/NaelSucksAtCoding/evolusi-pl-24-544963-SV-25579/actions/workflows/ci.yml/badge.svg)](https://github.com/NaelSucksAtCoding/evolusi-pl-24-544963-SV-25579/actions/workflows/ci.yml)

Repository tugas mata kuliah **Konstruksi & Evolusi Perangkat Lunak**.
Aplikasi web Laravel sederhana untuk mengelola data item (tambah, lihat, edit, hapus).

| | |
|---|---|
| Nama | Gunael Alexander Silalahi |
| NIM | 24/544963/SV/25579 |
| Kelas | A2 |

## Teknologi

- PHP 8.3 dan Laravel 13
- SQLite (bawaan) untuk pengembangan dan pengujian
- PHPUnit untuk pengujian, Laravel Pint untuk gaya kode
- GitHub Actions untuk Continuous Integration

## Cara menjalankan

```bash
git clone https://github.com/NaelSucksAtCoding/evolusi-pl-24-544963-SV-25579.git
cd evolusi-pl-24-544963-SV-25579
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Buka <http://127.0.0.1:8000>.

## Menjalankan dengan Docker

```bash
docker build -t evolusi-pl .
docker run -d --name evolusi-pl -p 8090:80 evolusi-pl
```

Buka <http://localhost:8090> untuk halaman CRUD dan <http://localhost:8090/api/items> untuk API JSON.
Saat container pertama kali jalan, [`docker/entrypoint.sh`](docker/entrypoint.sh) membuat `.env` dari
`.env.example`, menjalankan migrasi SQLite, dan mengisi data contoh.

Urutan [`Dockerfile`](Dockerfile) disusun agar cache bekerja: `composer.json` dan `composer.lock` disalin
dan dipasang **sebelum** kode aplikasi. Mengubah kode tidak memasang ulang dependensi.

## Pengujian

```bash
php artisan test        # menjalankan seluruh tes
vendor/bin/pint --test  # memeriksa gaya kode tanpa mengubah file
```

## Alur branch

```
feature/<nama>  ──PR──▶  dev  ──PR──▶  main
```

- `main` — selalu siap rilis. Tidak boleh di-push langsung.
- `dev` — tempat integrasi fitur sebelum dirilis.
- `feature/<nama>` — satu fitur per branch, dibuat dari `dev`.

`main` dan `dev` dilindungi *branch protection rule*: perubahan hanya bisa masuk lewat Pull Request
dan job **Build** serta **Run Tests** wajib hijau.

## Pipeline CI/CD

```
Build ──▶ Run Tests ──▶ Staging Deploy ──▶ Production Deploy
```

| Job | Isi | Kapan jalan |
|---|---|---|
| Build | `composer install` dan pemeriksaan gaya kode (Pint) | setiap push dan PR |
| Run Tests | `php artisan test` | setelah Build lulus |
| Staging Deploy | deploy ke staging (masih `echo`) | setelah Run Tests lulus |
| Production Deploy | tujuh langkah `deploy.sh` (masih `echo`) | hanya dari `main`, setelah disetujui reviewer di environment `production` |

Langkah deploy sebenarnya ada di [`deploy.sh`](deploy.sh) dan memakai `set -e`, sehingga deploy langsung
berhenti bila satu langkah gagal.

## Frontend Vue

Folder [`frontend/`](frontend/) berisi aplikasi Vue 3 yang mengambil data dari endpoint JSON
`GET /api/items`. Cara menjalankannya ada di [frontend/README.md](frontend/README.md).

Workflow terpisah, [`frontend.yml`](.github/workflows/frontend.yml):

```
Frontend Lint ──▶ Frontend Test ──▶ Frontend Build ──▶ Frontend Deploy
```

| Job | Isi | Kapan jalan |
|---|---|---|
| Frontend Lint | `npm ci` lalu oxlint + ESLint | setiap push ke `main`/`dev` dan setiap PR |
| Frontend Test | unit test Vitest, tanpa Laravel | setelah Lint lulus |
| Frontend Build | `npm run build`, `dist/` disimpan sebagai artifact | setelah Test lulus |
| Frontend Deploy | mengambil artifact `dist/` (tanpa build ulang) lalu menampilkan isinya | hanya push ke `main` |

## Pesan commit

Mengikuti [Conventional Commits](https://www.conventionalcommits.org/): `feat:`, `fix:`, `docs:`,
`style:`, `refactor:`, `test:`, `ci:`, `chore:`.
