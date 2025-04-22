import { defineStore } from 'pinia';
import authRequestApi from '@/apiRequest/auth';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
    }),
    actions: {
        async checkAuth() {
            // và trả về thông tin người dùng nếu đã đăng nhập.
            const response = await authRequestApi.auth();
            this.user = response.payload.data;
            console.log(this.user + 'check user');
            return this.user;
        },
        logout() {
            this.user = null;
        },
    },
});
