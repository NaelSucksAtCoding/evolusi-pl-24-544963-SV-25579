# Frontend Vue

Aplikasi Vue 3 yang menampilkan data item dari backend Laravel (`GET /api/items`).

| Halaman | Path | Isi |
|---|---|---|
| Beranda | `/` | penjelasan aplikasi dan alamat API yang dipakai |
| Daftar Item | `/items` | tabel item dari Laravel, bisa dicari |

## Menjalankan di laptop

Jalankan Laravel dulu dari root repository (`php artisan serve`), lalu:

```bash
cd frontend
cp .env.example .env   # isi VITE_API_URL, bawaan http://127.0.0.1:8000
npm ci
npm run dev            # buka http://localhost:5173
```

Alamat API selalu diambil dari `VITE_API_URL`, tidak ditulis langsung di kode.
Laravel hanya mengizinkan origin yang tercantum di `CORS_ALLOWED_ORIGINS` (bawaan: `http://localhost:5173`).

## Perintah lain

```bash
npm run lint    # oxlint + ESLint, tanpa mengubah file
npm test        # unit test Vitest (tidak butuh Laravel berjalan)
npm run build   # hasil build ke dist/
```
