// router/guards.js - Route guards
import type { CustomRouteMeta } from '@/types/router'
import useAuthStore from '../stores/useAuthStore'
import type { Router, NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export function setupRouterGuards(router: Router) {
  // Global before guard
  router.beforeEach(
    async (
      to: RouteLocationNormalized,
      from: RouteLocationNormalized,
      next: NavigationGuardNext,
    ) => {
      const authStore = useAuthStore()
      const meta = to.meta as CustomRouteMeta

      // Check if route requires authentication
      if (meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: 'login', query: { redirect: to.fullPath } })
        return
      }

      // Check if user is authenticated but trying to access auth pages
      if (meta.guestOnly && authStore.isAuthenticated) {
        next({ name: 'dashboard' })
        return
      }

      // Check user permissions
      if (meta.requiredPermissions && authStore.user.name) {
        const hasPermission = meta.requiredPermissions.every((permission) =>
          authStore.user.permissions.includes(permission as never),
        )

        if (!hasPermission) {
          next({ name: 'forbidden' })
          return
        }
      }

      // Validate user role
      if (to.meta.requiredRole) {
        if (authStore.user.role !== to.meta.requiredRole) {
          next({ name: 'unauthorized' })
          return
        }
      }

      next()
    },
  )

  // Global after guard
  router.afterEach((to, from, failure) => {
    // Update page title
    if (to.meta.title) {
      document.title = `${to.meta.title} - Career Compass`
    }

    // Track page views (analytics)
    // if (window.gtag && !failure) {
    //   gtag('config', 'GA_MEASUREMENT_ID', {
    //     page_title: to.meta.title || to.name,
    //     page_location: window.location.href,
    //   })
    // }
  })

  // Handle navigation errors
  router.onError((error) => {
    console.error('Router error:', error)
    // You could send to error tracking service here
  })
}
