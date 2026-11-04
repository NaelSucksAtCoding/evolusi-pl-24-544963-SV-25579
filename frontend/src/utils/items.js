/**
 * Menyaring item berdasarkan kata kunci pada nama atau deskripsi.
 * Pencarian tidak membedakan huruf besar/kecil dan mengabaikan spasi di tepi.
 */
export function filterItems(items, keyword) {
  const kunci = (keyword ?? '').trim().toLowerCase()

  if (kunci === '') {
    return items
  }

  return items.filter((item) =>
    [item.name, item.description].some((teks) => (teks ?? '').toLowerCase().includes(kunci)),
  )
}

/**
 * Memotong deskripsi panjang agar rapi di tabel, lalu menambahkan "…".
 * Deskripsi kosong ditampilkan sebagai tanda strip.
 */
export function ringkasDeskripsi(teks, panjangMaks = 40) {
  if (!teks) {
    return '-'
  }

  return teks.length > panjangMaks ? `${teks.slice(0, panjangMaks).trimEnd()}…` : teks
}
