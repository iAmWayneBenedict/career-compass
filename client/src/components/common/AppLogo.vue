<script setup lang="ts">
type Props = {
  title?: string
}

withDefaults(defineProps<Props>(), {
  title: 'Career Compass',
})
</script>

<template>
  <!-- <h4 class="mb-5 text-lg font-semibold text-center">
    {{ title }}
  </h4> -->
  <div class="flex items-center justify-center w-48 mb-8">
    <img src="/app-icon-dark.svg" alt="" />
  </div>
</template>
