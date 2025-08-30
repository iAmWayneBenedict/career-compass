<script setup lang="ts">
import type { SocialProvider } from '@/types/auth'
import CustomLink from '../customs/CustomLink.vue'
import { useToast } from 'primevue'

type Props = {
  providers?: SocialProvider[]
}

withDefaults(defineProps<Props>(), {
  providers: () => [],
})

const toast = useToast()

const handleSocialLogin = (provider: string) => {
  console.log('socialLogin', provider)

  toast.add({
    severity: 'info',
    summary: 'Social Login',
    detail: provider,
    life: 3000,
  })
}
</script>

<template>
  <div v-if="providers.length > 0" class="flex flex-col w-full gap-2">
    <template v-for="provider in providers" :key="provider.name">
      <CustomLink
        :to="provider.url || '#'"
        severity="secondary"
        :label="provider.label || ''"
        @click="handleSocialLogin(provider.name)"
      >
        {{ provider.label }}
        <template #icon>
          <component :is="provider.icon" />
        </template>
      </CustomLink>
    </template>
  </div>
</template>
