// store.js
import {createStore} from 'vuex';
import http from './lib/http';

export default createStore({
    state() {
        const user = localStorage.getItem('user');
        return {
            user: user ? JSON.parse(user) : null,
            isAuthenticated: false,
        };
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
            state.isAuthenticated = !!user;
            localStorage.setItem('user', JSON.stringify(user));
        },
        async logout(state) {
            try {
                await http.post('/auth/logout');
                state.user = null;
                state.isAuthenticated = false;
                localStorage.removeItem('user');
                localStorage.removeItem('sessionToken');
                localStorage.removeItem('sessionTokenExpiresAt');
                return {name: 'login'};
            } finally {
                // auth.removeToken();
                // commit('clearUser');
                // router.push('/login');
                location.href = '/';
            }
        },
    },
    actions: {
        login({commit}, user) {
            commit('setUser', user);
        },
        logout({commit}) {
            commit('logout');
        },
    },
});
