import type { Component } from 'vue'

export type SocialProvider = {
  name: string
  label: string
  icon: Component
  url?: string
}
