<script setup>
import { computed, onMounted, ref } from 'vue'
import { ambilItems } from '@/api/items'
import { filterItems, ringkasDeskripsi } from '@/utils/items'

const items = ref([])
const kataKunci = ref('')
const memuat = ref(true)
const galat = ref('')

const itemTampil = computed(() => filterItems(items.value, kataKunci.value))

onMounted(async () => {
  try {
    items.value = await ambilItems()
  } catch (error) {
    galat.value = error.message
  } finally {
    memuat.value = false
  }
})
</script>

<template>
  <section class="card">
    <h2>Daftar Item</h2>
    <p class="subjudul">Data diambil langsung dari Laravel (<code>GET /api/items</code>).</p>

    <input v-model="kataKunci" type="search" placeholder="Cari nama atau deskripsi…" />

    <p v-if="memuat" class="info">Memuat data…</p>
    <p v-else-if="galat" class="galat">{{ galat }}</p>

    <table v-else>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Deskripsi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in itemTampil" :key="item.id">
          <td>{{ item.name }}</td>
          <td>{{ ringkasDeskripsi(item.description) }}</td>
        </tr>
        <tr v-if="itemTampil.length === 0">
          <td colspan="2" class="info">Tidak ada item yang cocok.</td>
        </tr>
      </tbody>
    </table>

    <p v-if="!memuat && !galat" class="jumlah">
      Menampilkan {{ itemTampil.length }} dari {{ items.length }} item
    </p>
  </section>
</template>

<style scoped>
h2 {
  margin-top: 0;
}

.subjudul,
.jumlah {
  color: #6b7280;
  font-size: 0.85rem;
}

input {
  width: 100%;
  padding: 8px 10px;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font: inherit;
  margin-bottom: 12px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.9rem;
}

th,
td {
  text-align: left;
  padding: 10px 8px;
  border-bottom: 1px solid #f0f0f0;
}

th {
  color: #6b7280;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

.info {
  color: #9ca3af;
  text-align: center;
}

.galat {
  background: #fee2e2;
  color: #991b1b;
  padding: 10px 14px;
  border-radius: 8px;
}
</style>
