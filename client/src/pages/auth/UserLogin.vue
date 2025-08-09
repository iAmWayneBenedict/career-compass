<script setup lang="ts">
import AuthFooterLinks from '@/components/auth/AuthFooterLinks.vue'
import AuthForm from '@/components/auth/AuthForm.vue'
import AuthLayout from '@/components/auth/AuthLayout.vue'
import InputFormField from '@/components/common/InputFormField.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'
import type { SocialProvider } from '@/types/auth'
import { reactive, ref } from 'vue'
import Checkbox from 'primevue/checkbox'
import ShowPasswordToggle from '@/components/auth/ShowPasswordToggle.vue'

const form = reactive({
  email: '',
  password: '',
})

const showPassword = ref(false)

const errors = reactive({
  email: '',
  password: '',
})

const isLoading = ref(false)

const socialProviders: SocialProvider[] = [
  {
    name: 'google',
    label: 'Sign in with Google',
    icon: GoogleIcon,
  },
]

const footerLinks = [
  {
    text: "Don't have an account?",
    label: 'Register',
    to: '/auth/register',
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
      title="Welcome Back"
      subtitle="Log in with your Google account"
      submit-label="Login"
      :loading="isLoading"
      :social-providers="socialProviders"
      divider-text="Or continue with"
      @submit="handleLogin"
      @social-login="handleSocialLogin"
    >
      <template #fields>
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
          :type="showPassword ? 'text' : 'password'"
          v-model="form.password"
          placeholder="●●●●●●●●"
          :has-error="!!errors.password"
          :error-message="errors.password"
        />
      </template>
      <template #password-actions>
        <div class="flex justify-between w-full">
          <ShowPasswordToggle :show-password="showPassword" />
          <RouterLink to="/auth/forgot-password" class="text-sm text-gray-600 hover:underline">
            Forgot Password?
          </RouterLink>
        </div>
      </template>
      <template #footer-links>
        <AuthFooterLinks :links="footerLinks" />
      </template>
    </AuthForm>
  </AuthLayout>
</template>
