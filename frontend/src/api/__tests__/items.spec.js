import { describe, expect, it, vi } from 'vitest'
import { ambilItems, buatApiUrl } from '../items'

describe('buatApiUrl', () => {
  it('menggabungkan alamat dasar dan path tanpa garis miring ganda', () => {
    expect(buatApiUrl('/api/items', 'http://127.0.0.1:8000/')).toBe(
      'http://127.0.0.1:8000/api/items',
    )
  })

  it('menolak bila VITE_API_URL belum diatur', () => {
    expect(() => buatApiUrl('/api/items', '')).toThrow('VITE_API_URL belum diatur')
  })
})

describe('ambilItems', () => {
  it('mengambil data dari endpoint Laravel tanpa server sungguhan', async () => {
    const fetchPalsu = vi.fn().mockResolvedValue({
      ok: true,
      json: async () => ({ data: [{ id: 1, name: 'Bakwan', description: 'Bakwan goreng' }] }),
    })

    const items = await ambilItems(fetchPalsu, 'http://api.contoh')

    expect(fetchPalsu).toHaveBeenCalledWith('http://api.contoh/api/items', {
      headers: { Accept: 'application/json' },
    })
    expect(items).toEqual([{ id: 1, name: 'Bakwan', description: 'Bakwan goreng' }])
  })

  it('melempar error yang jelas bila server menjawab gagal', async () => {
    const fetchPalsu = vi.fn().mockResolvedValue({ ok: false, status: 500 })

    await expect(ambilItems(fetchPalsu, 'http://api.contoh')).rejects.toThrow('HTTP 500')
  })
})
