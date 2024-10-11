import { createStore } from 'vuex';
import axios from 'axios';

export default createStore({
  state: {
    user: null,
    token: localStorage.getItem('token') || '',
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('token', token);
    },
    clearAuthData(state) {
      state.token = '';
      state.user = null;
      localStorage.removeItem('token');
    },
  },
  actions: {
    async login({ commit }, credentials) {
      commit('clearAuthData');
      const response = await axios.post('/api/login', credentials);
      commit('setToken', response.data.token);
      commit('setUser', response.data.user);
    },
    async logout({ commit }) {
      try {
        await axios.post('/api/logout');
        commit('clearAuthData');
      } catch (error) {
        console.error('Logout error:', error.response ? error.response.data : error.message);
      }
    },
    async getUser({ commit }) {
      const response = await axios.get('/api/user');
      commit('setUser', response.data);
    },
  },
  getters: {
    isAuthenticated(state) {
      return !!state.token;
    },
    getUser(state) {
      return state.user;
    },
  },
});
