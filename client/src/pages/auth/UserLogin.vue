<script setup lang="ts">
import CustomLink from '@/components/customs/CustomLink.vue'
import GoogleIcon from '@/components/icons/GoogleIcon.vue'
import Button from 'primevue/button'
import Divider from 'primevue/divider'
import InputText from 'primevue/inputtext'
import Message from 'primevue/message'
</script>

<template>
  <div class="flex items-center justify-center w-screen h-screen">
    <!-- Card Parent -->
    <div class="max-w-[22rem] sm:max-w-[25rem] h-fit flex flex-col items-center">
      <!-- TODO: Change to the logo -->
      <h4 class="mb-5 text-lg font-semibold text-center">Career Compass</h4>

      <!-- Card Container -->
      <div class="flex flex-col justify-center w-full rounded-2xl">
        <!-- Card Header -->
        <div class="flex flex-col items-center mb-5">
          <h3 class="text-2xl font-medium text-center">Welcome Back</h3>
          <p class="text-sm text-center text-gray-500">Log in with your Google account</p>
        </div>
        <!-- END Card Header -->

        <!-- Card Social -->
        <div class="flex flex-col w-full gap-2">
          <!-- * Add other social login options -->
          <CustomLink to="#" severity="secondary" label="Sign in with Google">
            <template #icon>
              <GoogleIcon />
            </template>
          </CustomLink>
        </div>
        <!-- END Card Social -->

        <Divider align="center">
          <span class="text-xs text-gray-400">Or continue with</span>
        </Divider>

        <!-- Card Form -->
        <div class="flex flex-col gap-5">
          <div class="flex flex-col">
            <label for="password">Email</label>
            <InputText id="email" aria-describedby="email-help" placeholder="m@example.com" />

            <!-- TODO: Change the condition to check if the username is valid -->
            <Message v-if="false" size="small" severity="error" variant="simple">
              Enter your username to reset your password.
            </Message>
          </div>
          <div class="flex flex-col">
            <label for="password">Password</label>
            <InputText
              id="password"
              aria-describedby="email-help"
              type="password"
              placeholder="●●●●●●●●"
            />

            <!-- TODO: Change the condition to check if the username is valid -->
            <Message v-if="false" size="small" severity="error" variant="simple">
              Enter your username to reset your password.
            </Message>
          </div>

          <div class="flex flex-col w-full">
            <Button label="Login" />
          </div>

          <div class="flex flex-col w-full">
            <div class="flex flex-row items-center justify-center gap-2">
              <p class="text-sm text-gray-500">Don't have an account?</p>
              <CustomLink
                to="/auth/register"
                class="p-0 text-sm"
                severity="secondary"
                variant="link"
                label="Sign up"
              />
            </div>
          </div>
        </div>
      </div>
      <!-- END Card Form -->

      <!-- Disclaimer -->
      <div class="mt-5">
        <p class="text-xs text-center text-gray-500">
          By continuing, you agree to our
          <CustomLink
            to="#"
            severity="secondary"
            variant="link"
            class="p-0 text-xs"
            label="Terms of Use"
          />
          and
          <CustomLink
            to="#"
            severity="secondary"
            variant="link"
            class="p-0 text-xs"
            label="Privacy Policy"
          />
        </p>
      </div>
      <!-- END Disclaimer -->
    </div>
    <!-- END Card Container -->
  </div>
</template>
