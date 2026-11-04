import { describe, expect, it } from 'vitest'
import { filterItems, ringkasDeskripsi } from '../items'

const items = [
  { id: 1, name: 'Nasi Goreng', description: 'Nasi goreng spesial telur' },
  { id: 2, name: 'Bakwan', description: 'Bakwan sayur goreng' },
  { id: 3, name: 'Es Teh', description: null },
]

describe('filterItems', () => {
  it('mengembalikan semua item bila kata kunci kosong', () => {
    expect(filterItems(items, '')).toHaveLength(3)
    expect(filterItems(items, '   ')).toHaveLength(3)
  })

  it('mencari pada nama tanpa membedakan huruf besar/kecil', () => {
    expect(filterItems(items, 'BAKWAN').map((item) => item.id)).toEqual([2])
  })

  it('mencari pada deskripsi juga', () => {
    expect(filterItems(items, 'goreng').map((item) => item.id)).toEqual([1, 2])
  })

  it('tetap aman untuk item tanpa deskripsi', () => {
    expect(filterItems(items, 'teh').map((item) => item.id)).toEqual([3])
  })
})

describe('ringkasDeskripsi', () => {
  it('menampilkan strip untuk deskripsi kosong', () => {
    expect(ringkasDeskripsi(null)).toBe('-')
  })

  it('tidak mengubah deskripsi yang pendek', () => {
    expect(ringkasDeskripsi('Teh manis', 40)).toBe('Teh manis')
  })

  it('memotong deskripsi panjang dan menambahkan elipsis', () => {
    expect(ringkasDeskripsi('Ayam goreng sambal bawang pedas', 11)).toBe('Ayam goreng…')
  })
})
