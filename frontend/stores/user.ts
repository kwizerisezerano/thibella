import { defineStore } from 'pinia';

export const useUserStore = defineStore('user', {
  state: () => ({
    userId: null as string | null, // ✅ added — links user to their orders
    name: null as string | null,
    role: null as string | null,
    token: null as string | null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.token, // ✅ handy boolean for guards/UI
  },

  actions: {
    setUser(payload: { userId: string; name: string; role: string; token: string }) {
      this.userId = payload.userId
      this.name = payload.name
      this.role = payload.role
      this.token = payload.token

      localStorage.setItem('userId', payload.userId) // ✅ persist userId
      localStorage.setItem('name', payload.name)
      localStorage.setItem('role', payload.role)
      localStorage.setItem('token', payload.token)
    },

    logout() {
      this.userId = null
      this.name = null
      this.role = null
      this.token = null
      localStorage.clear()
    },

    hydrate() {
      this.userId = localStorage.getItem('userId') // ✅ restore userId
      this.name = localStorage.getItem('name')
      this.role = localStorage.getItem('role')
      this.token = localStorage.getItem('token')
    },
  },
});