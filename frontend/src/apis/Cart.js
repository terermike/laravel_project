import Api from './Api'

export default {
  // Get all items in the cart
  index() {
    return Api().get('/cart')
  },

  // Add a product to the cart
  addProduct(form) {
    return Api().post('/cart/add', form)
  },

  // Update a product in the cart
  updateProduct(form) {
    return Api().put('/cart/update', form)
  },

  // Remove a product from the cart
  removeProduct(form) {
    return Api().delete('/cart/remove', { data: form })
  }
}
