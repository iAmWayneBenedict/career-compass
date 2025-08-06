import type { RouteRecordRaw } from 'vue-router'

const homeRoutes: RouteRecordRaw[] = [
  {
    path: '',
    name: 'home',
    component: () => import('@/pages/home.vue'),
    meta: {
      title: 'Career Compass',
      description: 'Career Compass',
    },
  },
]

export default homeRoutes
