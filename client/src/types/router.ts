// router/types.ts - Type definitions
import type { RouteRecordRaw } from 'vue-router'

export type CustomRouteMeta = {
  title?: string
  description?: string
  breadcrumb?: string
  requiresAuth?: boolean
  guestOnly?: boolean
  requiredRole?: string
  requiredPermissions?: string[]
  layout?: string
  hideInMenu?: boolean
  icon?: string
}

export type CustomRouteRecord = Omit<RouteRecordRaw, 'meta'> & {
  meta?: CustomRouteMeta
}

export type User = {
  id: number
  email: string
  name: string
  role: string
  permissions: string[]
}
