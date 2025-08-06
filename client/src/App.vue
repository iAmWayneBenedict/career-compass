<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import './styles.css'
</script>

<template>
  <div id="app">
    <h1>Hello App!</h1>
    <p><strong>Current route path:</strong> {{ $route.fullPath }}</p>
    <nav>
      <RouterLink to="/">Go to Home</RouterLink>
      <RouterLink to="/auth/login">Go to Login</RouterLink>
      <RouterLink to="/auth/register">Go to Register</RouterLink>
    </nav>
    <main>
      <RouterView />
    </main>
  </div>
</template>
