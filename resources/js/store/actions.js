import axios from 'axios'

export default {
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
    },
    categories({commit}) {
        return new Promise((resolve) => {
            axios({url: '/api/categories', method: 'GET'})
            .then(resp => {
                commit('categories', resp.data.categories)
                resolve()
            })
        })
    },
    new_category({commit}, category) {
        return new Promise((resolve) => {
            axios({url: '/api/categories',  data: category, method: 'POST'})
            .then(resp => {
                commit('new_category', resp.data.category)
                resolve()
            })
            .catch( err => console.log(err) )
        })
    }
}