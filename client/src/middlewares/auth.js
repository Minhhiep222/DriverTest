// middlewares/auth.js
import { useAuthStore } from '@/stores/auth'

export const authMiddleware = {
  // Kiểm tra authentication
  async requireAuth(to, from) {
    const authStore = useAuthStore()
    const data = await authStore.checkAuth()

    console.log(data, 'data')

    if (!data.user || !('id' in data.user)) {
      return { name: 'login' }
    }

    return true
  },

  // Kiểm tra đã login chưa
  async checkLoggedIn(to, from) {
    const user = localStorage.getItem('user')
    const sessionToken = localStorage.getItem('sessionToken')

    if (user !== null && sessionToken !== null) {
      return '/'
    }

    return true
  },

  // Kiểm tra role admin
  async requireAdmin(to, from) {
    const authStore = useAuthStore()
    const data = await authStore.checkAuth()

    if (!data.user || data.user.role !== 'admin') {
      return data.user.role === 'user' ? { name: 'drive-management' } : '/'
    }

    return true
  },

  // Kiểm tra role user
  async requireUser(to, from) {
    const authStore = useAuthStore()
    const data = await authStore.checkAuth()

    if (
      !data.user ||
      (data.user.role !== 'user' && data.user.role !== 'admin')
    ) {
      return '/'
    }

    return true
  },
}
