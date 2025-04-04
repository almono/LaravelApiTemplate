import { defineStore } from 'pinia';
import api from '../../api.js';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null
  }),
  actions: {
    async login(credentials) {
      await api.get('/sanctum/csrf-cookie') // CSRF protection
      
      const response = await api.post('/api/auth/login', credentials)
console.log(response.status)
console.log(response)
      if(response.status === 200) {
        console.log("TEST1")
        this.token = response.data.accessToken
        console.log("TEST2")
        api.defaults.headers.common["Authorization"] = `Bearer ${this.token}`
        console.log("TEST3")
console.log(this.token)
        await this.fetchUser()
      }
    },

    async register(data) {
      try {
        const response = await api.post('/api/auth/register', { ...data })
        this.user = response.data;
      } catch {
        this.user = null;
      }
    },

    async fetchUser() {
      try {
        const response = await api.get('/api/auth/user')
        this.user = response.data
      } catch {
        this.user = null;
      }
    },

    async logout() {
      await api.post('/logout')
      this.user = null
      this.token = null

      // Remove token from Axios
      delete axios.defaults.headers.common["Authorization"]
    },
  },
});
