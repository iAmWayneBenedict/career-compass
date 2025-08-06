import type { RouteRecordRaw } from 'vue-router'

const authRoutes: RouteRecordRaw[] = [
  {
    path: 'login',
    name: 'login',
    component: () => import('@/pages/auth/login.vue'),
  },
  {
    path: 'register',
    name: 'register',
    component: () => import('@/pages/auth/register.vue'),
  },
  {
    path: 'forgot-password',
    name: 'forgot-password',
    component: () => import('@/pages/auth/forgot-password.vue'),
  },
]

export default authRoutes
