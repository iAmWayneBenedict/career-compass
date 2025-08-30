<script setup lang="ts">
import { RouterView } from 'vue-router'
import Toast from 'primevue/toast'
import './styles/index.css'
</script>

<template>
  <div id="app">
    <main>
      <RouterView />
      <Toast />
    </main>
  </div>
</template>
