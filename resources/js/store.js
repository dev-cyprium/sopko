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
        logout(state) {
            state.user = {}
            state.status = ''
            state.token = ''
        }
    },
    actions: {
        login({commit}, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                axios({url: '/api/login', data: user, method: 'POST'})
                .then(resp => {
                    const {apiKey, fullName} = resp.data
                    localStorage.setItem('token', apiKey)
                    axios.defaults.headers.common['Authorization'] = apiKey
                    commit('auth_success', apiKey, fullName)
                    resolve(resp)
                })
                .catch(err => {
                    commit('auth_error')
                    localStorage.removeItem('token')
                    reject(err)
                })
            });
        },
        logout({commit}) {
            return new Promise((resolve) => {
                commit('logout')
                localStorage.removeItem('token')
                delete axios.defaults.headers.common['Authorization']
                resolve()
            })
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status
    }
})