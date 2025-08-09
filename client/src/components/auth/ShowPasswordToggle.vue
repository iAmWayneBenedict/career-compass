<script setup lang="ts">
import Checkbox from 'primevue/checkbox'
import { ref, watch } from 'vue'

type Props = {
  showPassword: boolean
}
const props = defineProps<Props>()

const showPassword = ref(props.showPassword)
console.log(showPassword)

defineEmits(['update:showPassword'])
</script>

<template>
  <div class="flex items-center gap-2">
    <Checkbox
      v-model="showPassword"
      name="show-password"
      inputId="show-password"
      binary
      @update:modelValue="$emit('update:showPassword', $event!)"
      size="small"
    />
    <label for="show-password" class="text-sm cursor-pointer">Show Password</label>
  </div>
</template>
