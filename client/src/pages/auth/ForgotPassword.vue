<script setup lang="ts">
import AuthFooterLinks from '@/components/auth/AuthFooterLinks.vue'
import AuthForm from '@/components/auth/AuthForm.vue'
import AuthLayout from '@/components/auth/AuthLayout.vue'
import InputFormField from '@/components/common/InputFormField.vue'
import { reactive, ref } from 'vue'

const footerLinks = [
  {
    text: '',
    label: 'Go back',
    to: '/auth/login',
  },
]

const form = reactive({
  email: '',
})

const errors = reactive({
  email: '',
})

const isLoading = ref(false)

const handleSubmit = () => {
  console.log('Submit')
}
</script>

<template>
  <AuthLayout>
    <AuthForm
      title="Forgot Password"
      subtitle="Enter your email address"
      submit-label="Submit"
      :loading="isLoading"
      :show-divider="false"
      divider-text="Or continue with"
      @submit="handleSubmit"
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
      </template>
      <template #footer-links>
        <AuthFooterLinks :links="footerLinks" />
      </template>
    </AuthForm>
  </AuthLayout>
</template>

<style scoped></style>
