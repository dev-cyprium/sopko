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
    },
    update_category({commit, dispatch}, {data, id}) {
        return new Promise((resolve) => {
            axios({url: `/api/categories/${id}`, data, method: 'PUT'})
                .then(resp => {
                    dispatch('categories')
                    resolve()
                })
                .catch( err => console.log(err))
        })
    },
    delete_category({commit, dispatch}, id) {
        return new Promise((resolve) => {
            axios({url: `/api/categories/${id}`, method: 'DELETE'})
                .then(resp => {
                    dispatch('categories')
                    resolve()
                })
                .catch(err => console.log(err))
        })
    },
    images({commit}) {
        return new Promise((resolve) => {
            axios({url: '/api/images', method: 'GET'})
                .then(resp => {
                    commit('images', resp.data.images)
                    resolve()
                })
        })
    },
    new_image({commit, dispatch}, {contentType, binary}) {
        return new Promise((resolve) => {
            axios({
                headers: {"Content-Type": contentType},
                url: `/api/images`, 
                method: 'POST', 
                data: binary
            })
            .then(resp => {
                dispatch('images')
                resolve()
            })
            .catch(err => console.log(err))
        })
    }
}