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

## Pesan commit

Mengikuti [Conventional Commits](https://www.conventionalcommits.org/): `feat:`, `fix:`, `docs:`,
`style:`, `refactor:`, `test:`, `ci:`, `chore:`.
