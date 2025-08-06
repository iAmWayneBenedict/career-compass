import type { RouteRecordRaw } from 'vue-router'
import homeRoutes from './home'
import authRoutes from './auth'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    children: homeRoutes,
  },
  {
    path: '/auth',
    children: authRoutes,
  },
]

export default routes
