<script setup lang="ts">
import Button from 'primevue/button'
import AuthHeader from './AuthHeader.vue'
import FormDivider from './FormDivider.vue'
import SocialLogin from './SocialLogin.vue'
import type { SocialProvider } from '@/types/auth'

type Props = {
  title: string
  subtitle?: string
  submitLabel: string
  showDivider?: boolean
  loading?: boolean
  disabled?: boolean
  socialProviders?: SocialProvider[]
  dividerText?: string
}

type Emits = {
  submit: []
  socialLogin: [provider: string]
}

withDefaults(defineProps<Props>(), {
  loading: false,
  disabled: false,
  showDivider: true,
  socialProviders: () => [],
  dividerText: '',
})

defineEmits<Emits>()
</script>

<template>
  <div class="flex flex-col">
    <AuthHeader :title="title" :subtitle="subtitle" />
    <SocialLogin
      v-if="socialProviders.length > 0"
      :providers="socialProviders"
      @social-login="$emit('socialLogin', $event)"
    />

    <FormDivider :text="dividerText" v-if="showDivider" />

    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-5">
      <slot name="fields" />

      <slot name="password-actions" />
      <div class="flex flex-col w-full gap-2">
        <Button
          :label="submitLabel"
          :loading="loading"
          :disabled="disabled || loading"
          type="submit"
        />

        <slot name="additional-actions" />
      </div>

      <slot name="footer-links" />
    </form>
  </div>
</template>
