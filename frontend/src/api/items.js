/**
 * Menggabungkan alamat dasar API (dari VITE_API_URL) dengan path endpoint,
 * tanpa menghasilkan garis miring ganda.
 */
export function buatApiUrl(path, baseUrl = import.meta.env.VITE_API_URL) {
  if (!baseUrl) {
    throw new Error('VITE_API_URL belum diatur. Salin frontend/.env.example menjadi frontend/.env.')
  }

  return `${baseUrl.replace(/\/+$/, '')}/${path.replace(/^\/+/, '')}`
}

/**
 * Mengambil daftar item dari Laravel (GET /api/items).
 * fetchFn bisa diganti saat pengujian sehingga test tidak butuh Laravel berjalan.
 */
export async function ambilItems(fetchFn = fetch, baseUrl = import.meta.env.VITE_API_URL) {
  const respons = await fetchFn(buatApiUrl('/api/items', baseUrl), {
    headers: { Accept: 'application/json' },
  })

  if (!respons.ok) {
    throw new Error(`Gagal memuat item (HTTP ${respons.status})`)
  }

  const isi = await respons.json()

  return isi.data
}
