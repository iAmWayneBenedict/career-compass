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
    component: () => import('@/pages/auth/Register.vue'),
  },
  {
    path: 'forgot-password',
    name: 'forgot-password',
    component: () => import('@/pages/auth/ForgotPassword.vue'),
  },
]

export default authRoutes
