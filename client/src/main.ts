import { createApp } from 'vue'
import { createPinia } from 'pinia'
import PrimeVue from 'primevue/config'

import { VueQueryPlugin } from '@tanstack/vue-query'
import ToastService from 'primevue/toastservice'

import App from './App.vue'
import router from './router'
import { ThemePreset } from './config'
const app = createApp(App)

app.use(createPinia())
app.use(router)

app.use(VueQueryPlugin)
app.use(ToastService)

app.use(PrimeVue, {
  ripple: true,
  theme: {
    preset: ThemePreset,
    options: {
      darkModeSelector: '.my-app-dark',
      cssLayer: {
        name: 'primevue',
        order: 'theme, base, primevue',
      },
    },
  },
})

app.mount('#app')
