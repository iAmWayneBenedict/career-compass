<script setup lang="ts">
import AppLogo from '../common/AppLogo.vue'
import AuthCard from './AuthCard.vue'
import AuthDisclaimer from './AuthDisclaimer.vue'

type Props = {
  logoTitle?: string
  showDisclaimer?: boolean
}

withDefaults(defineProps<Props>(), {
  logoTitle: 'Career Compass',
  showDisclaimer: true,
})
</script>

<template>
  <div class="flex items-center justify-center w-screen h-screen">
    <AuthCard>
      <template #header>
        <AppLogo :title="logoTitle" />
      </template>

      <slot />

      <template #footer>
        <AuthDisclaimer />
      </template>
    </AuthCard>
  </div>
</template>
