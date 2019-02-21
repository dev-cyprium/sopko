import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('token') || '',
        status: '',
        user: {}
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, token, user) {
            state.status = 'success'
            state.token = token
            state.user = user
        },
        auth_error(state) {
            state.status = 'error'
        },
    },
    actions: {
        login({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({url: '/login', data: user, method: 'POST'})
                .then(resp => {
                    const {token, user} = resp.data
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = token
                    commit('auth_success', token, user)
                    resolve(resp)
                })
                .catch(err => {
                    commit('auth_error')
                    localStorage.removeItem('token')
                    reject(err)
                })
            });
        },
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status
    }
})