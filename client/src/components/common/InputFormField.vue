<script setup lang="ts">
import { Textarea } from 'primevue'
import InputText from 'primevue/inputtext'
import Message from 'primevue/message'
import { useField } from 'vee-validate'

type Props = {
  id: string
  name: string
  label?: string
  type?: string
  placeholder?: string
  hint?: string
  disabled?: boolean
}

type Emits = {
  'update:modelValue': [value: string]
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  hasError: false,
  disabled: false,
})

defineEmits<Emits>()

const { value, errorMessage } = useField<string>(() => props.name)
</script>

<template>
  <div class="flex flex-col">
    <label v-if="label" :for="id">{{ label }}</label>

    <InputText
      v-if="type !== 'textarea'"
      :id="id"
      :type="type"
      :placeholder="placeholder"
      v-model="value"
      :disabled="disabled"
      :aria-describedby="`${id}-help`"
      :invalid="!!errorMessage"
    />

    <Textarea
      v-else
      :id="id"
      :placeholder="placeholder"
      v-model="value"
      :disabled="disabled"
      :aria-describedby="`${id}-help`"
      class="p-3 border rounded-md"
      :invalid="!!errorMessage"
    />

    <!-- <textarea
      v-else
      :id="id"
      :placeholder="placeholder"
      :model-value="value"
      :disabled="disabled"
      :aria-describedby="`${id}-help`"
      class="p-3 border rounded-md"
      @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
    /> -->

    <small v-if="hint && !errorMessage" class="mt-1 text-xs text-gray-500">
      {{ hint }}
    </small>

    <Message v-if="errorMessage" size="small" severity="error" variant="simple">
      {{ errorMessage }}
    </Message>
  </div>
</template>
