<script setup lang="ts">
import CustomLink from '../customs/CustomLink.vue'
</script>

<template>
  <div class="mt-5">
    <p class="text-xs text-center text-gray-500">
      By continuing, you agree to our
      <CustomLink
        to="#"
        severity="secondary"
        variant="link"
        class="p-0 text-xs"
        label="Terms of Use"
      />
      and
      <CustomLink
        to="#"
        severity="secondary"
        variant="link"
        class="p-0 text-xs"
        label="Privacy Policy"
      />
    </p>
  </div>
</template>
