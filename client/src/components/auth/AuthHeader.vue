<script setup lang="ts">
type Props = {
  title: string
  subtitle?: string
}

defineProps<Props>()
</script>

<template>
  <div class="flex flex-col items-center mb-5">
    <h3 class="text-2xl font-medium text-center">{{ title }}</h3>
    <p v-if="subtitle" class="text-sm text-center text-gray-500">{{ subtitle }}</p>
  </div>
</template>
