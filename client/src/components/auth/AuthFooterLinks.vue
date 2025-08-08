<template>
  <div class="flex flex-col w-full gap-2">
    <div
      v-for="link in links"
      :key="link.text"
      class="flex flex-row items-center justify-center gap-2"
    >
      <p class="text-sm text-gray-500">{{ link.text }}</p>
      <CustomLink
        :to="link.to"
        :class="link.class || 'p-0 text-sm'"
        severity="secondary"
        variant="link"
        :label="link.label"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import CustomLink from '../customs/CustomLink.vue'

type FooterLink = {
  text: string
  label: string
  to: string
  class?: string
}

type Props = {
  links: FooterLink[]
}

defineProps<Props>()
</script>
