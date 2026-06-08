import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    userId: null as string | null,  
    status: null as string | null,
  }),
  actions: {
    
    setUser(authResponse: { userId: string; status: string }) {
      this.userId = authResponse.userId;
      this.status = authResponse.status;
    
      // Save to local storage
      if (import.meta.client) {
        localStorage.setItem('userId', authResponse.userId);
        localStorage.setItem('authStatus', authResponse.status);
      }
    },
     logout() {
      this.userId = null;
      this.status = null;

      // Remove from local storage
      if (import.meta.client) {
      localStorage.removeItem('userId');
      localStorage.removeItem('authStatus');

      }
    },

    }
  }
);
