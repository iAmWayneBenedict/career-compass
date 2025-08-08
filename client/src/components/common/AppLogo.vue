<template>
  <h4 class="mb-5 text-lg font-semibold text-center">
    {{ title }}
  </h4>
</template>

<script setup lang="ts">
interface Props {
  title?: string
}

withDefaults(defineProps<Props>(), {
  title: 'Career Compass',
})
</script>
