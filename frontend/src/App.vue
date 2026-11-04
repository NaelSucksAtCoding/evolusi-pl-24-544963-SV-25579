<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="container">
    <header>
      <h1>Evolusi PL — Frontend Vue</h1>
      <nav>
        <RouterLink to="/">Beranda</RouterLink>
        <RouterLink to="/items">Daftar Item</RouterLink>
      </nav>
    </header>

    <main>
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
header {
  margin-bottom: 24px;
}

h1 {
  font-size: 1.5rem;
  margin: 0 0 12px;
  color: #0c2d48;
}

nav {
  display: flex;
  gap: 8px;
}

nav a {
  padding: 6px 14px;
  border-radius: 6px;
  color: #1e4f7a;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
}

nav a.router-link-exact-active {
  background: #1e4f7a;
  color: #fff;
}
</style>
