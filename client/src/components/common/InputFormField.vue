<template>
  <div class="flex flex-col">
    <label v-if="label" :for="id">{{ label }}</label>

    <InputText
      v-if="type !== 'textarea'"
      :id="id"
      :type="type"
      :placeholder="placeholder"
      :model-value="modelValue"
      :disabled="disabled"
      :aria-describedby="`${id}-help`"
      @update:model-value="$emit('update:modelValue', $event!)"
    />

    <textarea
      v-else
      :id="id"
      :placeholder="placeholder"
      :model-value="modelValue"
      :disabled="disabled"
      :aria-describedby="`${id}-help`"
      class="p-3 border rounded-md"
      @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
    />

    <small v-if="hint && !hasError" class="mt-1 text-xs text-gray-500">
      {{ hint }}
    </small>

    <Message v-if="hasError && errorMessage" size="small" severity="error" variant="simple">
      {{ errorMessage }}
    </Message>
  </div>
</template>

<script setup lang="ts">
import InputText from 'primevue/inputtext'
import Message from 'primevue/message'

type Props = {
  id: string
  label?: string
  modelValue: string
  type?: string
  placeholder?: string
  hint?: string
  hasError?: boolean
  errorMessage?: string
  disabled?: boolean
}

type Emits = {
  'update:modelValue': [value: string]
}

withDefaults(defineProps<Props>(), {
  type: 'text',
  hasError: false,
  disabled: false,
})

defineEmits<Emits>()
</script>
