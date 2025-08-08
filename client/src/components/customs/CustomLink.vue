<script setup lang="ts">
import Button, { type ButtonProps } from 'primevue/button'
import { RouterLink, type RouteLocationRaw } from 'vue-router'

type Props = /* @vue-ignore */ Omit<ButtonProps, 'as'> & {
  to: RouteLocationRaw
}

const props = defineProps<Props>()
</script>

<template>
  <Button :as="RouterLink" v-bind="props" :to="props.to">
    <template #icon v-if="$slots.icon">
      <slot name="icon" />
    </template>
  </Button>
</template>
