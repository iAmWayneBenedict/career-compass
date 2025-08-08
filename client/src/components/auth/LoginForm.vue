<script setup lang="ts">
import type { SocialProvider } from '@/types/auth'
import AuthHeader from './AuthHeader.vue'
import FormDivider from './FormDivider.vue'
import SocialLogin from './SocialLogin.vue'

type Props = {
  title: string
  subtitle?: string
  submitLabel: string
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

    <FormDivider :text="dividerText" />

    <form @submit.prevent="$emit('submit')" class="flex flex-col gap-5">
      <slot name="fields" />

      <div class="flex flex-col w-full gap-2">
        <Button :label="submitLabel" :loading="loading" :disabled="disabled" type="submit" />

        <slot name="additional-actions" />
      </div>

      <slot name="footer-links" />
    </form>
  </div>
</template>
