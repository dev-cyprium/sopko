export default {
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
    },
    categories(state, categories) {
        state.productCategories = categories 
    },
    new_category(state, category) {
        state.productCategories = [...state.productCategories, category]
    },
    images(state, images) {
        state.images = images
    },
}