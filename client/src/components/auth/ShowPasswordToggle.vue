first one
<script setup lang="ts">
import Checkbox from 'primevue/checkbox'

const emits = defineEmits(['update:showPassword'])

defineProps<{
  showPassword: boolean
}>()
</script>

<template>
  <div class="flex items-center gap-2">
    <Checkbox
      :model-value="showPassword"
      name="show-password"
      inputId="show-password"
      binary
      @update:model-value="(value) => emits('update:showPassword', value)"
      size="small"
    />
    <label for="show-password" class="text-sm cursor-pointer">Show Password</label>
  </div>
</template>
