import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    userId: null as string | null,
    status: null as string | null,
    token: null as string | null,
  }),
  actions: {
    setUser(authResponse: { userId: string; status: string; token: string }) {
      this.userId = authResponse.userId;
      this.status = authResponse.status;
      this.token  = authResponse.token;

      if (import.meta.client) {
        localStorage.setItem('userId', authResponse.userId);
        localStorage.setItem('authStatus', authResponse.status);
        localStorage.setItem('authToken', authResponse.token);
      }
    },
    logout() {
      this.userId = null;
      this.status = null;
      this.token  = null;

      if (import.meta.client) {
        localStorage.removeItem('userId');
        localStorage.removeItem('authStatus');
        localStorage.removeItem('authToken');
      }
    },
    loadFromStorage() {
      if (import.meta.client) {
        this.userId = localStorage.getItem('userId');
        this.status = localStorage.getItem('authStatus');
        this.token  = localStorage.getItem('authToken');
      }
    },

    }
  }
);
