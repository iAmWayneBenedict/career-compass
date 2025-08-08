<script setup lang="ts">
import Divider from 'primevue/divider'

type Props = {
  text?: string
}

defineProps<Props>()
</script>

<template>
  <Divider v-if="text" align="center">
    <span class="text-xs text-gray-400">{{ text }}</span>
  </Divider>
</template>
