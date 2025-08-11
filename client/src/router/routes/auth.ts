import type { RouteRecordRaw } from 'vue-router'

const authRoutes: RouteRecordRaw[] = [
  {
    path: 'login',
    name: 'login',
    component: () => import('@/pages/auth/UserLogin.vue'),
  },
  {
    path: 'register',
    name: 'register',
    component: () => import('@/pages/auth/UserRegister.vue'),
  },
  {
    path: 'forgot-password',
    name: 'forgot-password',
    component: () => import('@/pages/auth/ForgotPassword.vue'),
  },
  {
    path: 'otp-verification',
    name: 'otp-verification',
    component: () => import('@/pages/auth/OTPVerification.vue'),
  },
]

export default authRoutes
