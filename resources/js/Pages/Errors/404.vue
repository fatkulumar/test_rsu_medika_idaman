<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Page Not Found" />
  <div class="flex flex-col items-center justify-center min-h-screen text-center">
    <h1 class="text-6xl font-bold text-red-600">404</h1>
    <p class="text-xl text-gray-600 mt-4">Oops! Halaman tidak ditemukan.</p>
    <a href="/" class="mt-6 text-blue-500 hover:underline">Kembali ke Beranda</a>
  </div>
</template>
