<script setup lang="ts">
import { onMounted } from 'vue'

const req = async () => {
  // const res = await fetch('http://127.0.0.1:8000/sanctum/csrf-cookie', {
  //   method: 'GET',
  //   credentials: 'include', // Important for cookies
  //   mode: 'cors', // Enable CORS
  //   headers: {
  //     Accept: 'application/json',
  //     'Content-Type': 'application/json',
  //   },
  // })

  const data = await fetch('http://127.0.0.1:8000/api/register', {
    method: 'POST',
    credentials: 'include', // Important for cookies
    mode: 'cors', // Enable CORS
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      'X-XSRF-TOKEN': decodeURIComponent(document.cookie.split('=')[1]),
    },
  })

  const json = await data.json()
  console.log(json)
}
console.log()
onMounted(() => {
  req()
})
</script>

<template>
  <h1>Home</h1>
</template>
