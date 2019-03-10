export default {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    categoryID: state => name => state.productCategories.find(cn => name == cn.title).id
}