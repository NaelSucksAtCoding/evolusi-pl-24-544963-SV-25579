<script setup>
const apiUrl = import.meta.env.VITE_API_URL
</script>

<template>
  <section class="card">
    <h2>Beranda</h2>
    <p>
      Aplikasi ini adalah frontend Vue 3 untuk tugas Konstruksi &amp; Evolusi Perangkat Lunak. Data
      item diambil dari backend Laravel melalui endpoint <code>GET /api/items</code>.
    </p>
    <p>
      Alamat API saat ini: <code>{{ apiUrl || 'belum diatur' }}</code>
      <small>(diambil dari variabel <code>VITE_API_URL</code>)</small>
    </p>
    <RouterLink to="/items" class="btn">Lihat daftar item</RouterLink>
  </section>
</template>

<style scoped>
h2 {
  margin-top: 0;
}

small {
  color: #6b7280;
}
</style>
