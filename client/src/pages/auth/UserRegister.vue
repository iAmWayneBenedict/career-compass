<script setup lang="ts">
import AuthFooterLinks from '@/components/auth/AuthFooterLinks.vue'
import AuthForm from '@/components/auth/AuthForm.vue'
import AuthLayout from '@/components/auth/AuthLayout.vue'
import ShowPasswordToggle from '@/components/auth/ShowPasswordToggle.vue'
import InputFormField from '@/components/common/InputFormField.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'
import type { SocialProvider } from '@/types/auth'
import { registerSchema } from '@/types/schema/auth-schema'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'

const { handleSubmit } = useForm({
  validationSchema: toTypedSchema(registerSchema),
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

const onSubmit = handleSubmit((values) => {
  // TODO: Implement login logic
  console.log(values)
})

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
      @submit="onSubmit"
      @social-login="handleSocialLogin"
    >
      <template #fields>
        <InputFormField name="name" id="name" label="Name" placeholder="Example Name" />
        <InputFormField id="email" label="Email" name="email" placeholder="m@example.com" />

        <InputFormField
          name="password"
          id="password"
          label="Password"
          placeholder="●●●●●●●●"
          :type="showPassword ? 'text' : 'password'"
        />
        <InputFormField
          name="confirmPassword"
          id="confirm-password"
          label="Confirm Password"
          placeholder="●●●●●●●●"
          :type="showPassword ? 'text' : 'password'"
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
