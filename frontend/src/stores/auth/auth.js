import { defineStore } from 'pinia';
import api from '../../api.js';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),
  actions: {
    async login(credentials) {
      await api.get('/sanctum/csrf-cookie', { withCredentials: true }); // CSRF protection
      
      const response = await api.post('/api/auth/login', credentials);
      if(response.status === 200) {
        await this.fetchUser()
      }
    },

    async fetchUser() {
      console.log("USER")
      try {
        const response = await api.get('/user');
        this.user = response.data;
      } catch {
        this.user = null;
      }
    },

    async logout() {
      await api.post('/logout');
      this.user = null;
    },
  },
});
