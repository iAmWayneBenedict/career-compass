import { defineStore } from 'pinia'

const useAuthStore = defineStore('auth', {
  state: () => ({
    user: {
      id: 0,
      email: '',
      name: '',
      role: '',
      permissions: [],
    },
    isAuthenticated: false,
    token: localStorage.getItem('token') || null,
  }),
  getters: {
    getUser: (state) => {
      return state.user
    },
  },
  actions: {
    login(token: string) {
      this.token = token
      localStorage.setItem('token', token)
      this.isAuthenticated = true
    },
    logout() {
      this.token = null
      localStorage.removeItem('token')
      this.isAuthenticated = false
    },
  },
})

export default useAuthStore
