<script setup lang="ts">
import AuthForm from '@/components/auth/AuthForm.vue'
import AuthLayout from '@/components/auth/AuthLayout.vue'
import InputFormField from '@/components/common/InputFormField.vue'
import InputOtp from 'primevue/inputotp'
import { reactive, ref } from 'vue'

const isLoading = ref(false)

const handleSubmit = () => {
  console.log('Submit')
}

const footerLinks = [
  {
    text: '',
    label: 'Go back',
    to: '/auth/login',
  },
]

const errors = reactive({
  otp: '',
})

const form = reactive({
  otp: '',
})
</script>

<template>
  <AuthLayout>
    <AuthForm
      title="OTP Verification"
      subtitle="Enter your OTP code sent to your email address"
      submit-label="Submit"
      :loading="isLoading"
      :show-divider="false"
      @submit="handleSubmit"
    >
      <template #fields>
        <div class="flex justify-center">
          <InputOtp
            id="email"
            label="Email"
            v-model="form.otp"
            placeholder=""
            :has-error="!!errors.otp"
            :error-message="errors.otp"
          />
        </div>
      </template>
      <template #footer-links>
        <AuthFooterLinks :links="footerLinks" />
      </template>
    </AuthForm>
  </AuthLayout>
</template>

<style scoped></style>
