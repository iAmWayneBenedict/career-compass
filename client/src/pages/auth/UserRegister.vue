<script setup lang="ts">
import AuthFooterLinks from '@/components/auth/AuthFooterLinks.vue'
import AuthForm from '@/components/auth/AuthForm.vue'
import AuthLayout from '@/components/auth/AuthLayout.vue'
import ShowPasswordToggle from '@/components/auth/ShowPasswordToggle.vue'
import InputFormField from '@/components/common/InputFormField.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'
import type { SocialProvider } from '@/types/auth'
import { reactive, ref } from 'vue'

const form = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
})

const errors = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
})

const isLoading = ref(false)
const showPassword = ref(false)

const socialProviders: SocialProvider[] = [
  {
    name: 'google',
    label: 'Sign in with Google',
    icon: GoogleIcon,
  },
]

const footerLinks = [
  {
    text: 'Already have an account?',
    label: 'Login',
    to: '/auth/login',
  },
]

const handleLogin = () => {
  // TODO: Implement login logic
  console.log('Login:', form)
}

const handleSocialLogin = (provider: string) => {
  // TODO: Implement social login
  console.log('Social login:', provider)
}
</script>

<template>
  <AuthLayout>
    <AuthForm
      title="Welcome"
      subtitle="Register with your Google account"
      submit-label="Register"
      :loading="isLoading"
      :social-providers="socialProviders"
      divider-text="Or continue with"
      @submit="handleLogin"
      @social-login="handleSocialLogin"
    >
      <template #fields>
        <InputFormField
          id="name"
          label="Name"
          v-model="form.name"
          placeholder="Example Name"
          :has-error="!!errors.name"
          :error-message="errors.name"
        />
        <InputFormField
          id="email"
          label="Email"
          v-model="form.email"
          placeholder="m@example.com"
          :has-error="!!errors.email"
          :error-message="errors.email"
        />

        <InputFormField
          id="password"
          label="Password"
          v-model="form.password"
          placeholder="●●●●●●●●"
          :type="showPassword ? 'text' : 'password'"
          :has-error="!!errors.password"
          :error-message="errors.password"
        />
        <InputFormField
          id="confirm-password"
          label="Confirm Password"
          v-model="form.confirmPassword"
          placeholder="●●●●●●●●"
          :type="showPassword ? 'text' : 'password'"
          :has-error="!!errors.confirmPassword"
          :error-message="errors.confirmPassword"
        />
      </template>
      <template #password-actions>
        <div class="flex justify-between w-full">
          <ShowPasswordToggle v-model:show-password="showPassword" />
        </div>
      </template>
      <template #footer-links>
        <AuthFooterLinks :links="footerLinks" />
      </template>
    </AuthForm>
  </AuthLayout>
</template>
