import Api from './Api'

export default {
  // Get all products
  index() {
    return Api().get('/products')
  },
  // Search product
  search(searchTerm) {
    return Api().get(`/products/search?name=${encodeURIComponent(searchTerm)}`)
  },
  // Get a specific product
  show(id) {
    return Api().get(`/products/${id}`)
  },

  // Create a new product
  store(form) {
    return Api().post('/products', form)
  },

  // Update an existing product
  update(id, form) {
    return Api().put(`/products/${id}`, form)
  },

  // Delete a product
  destroy(id) {
    return Api().delete(`/products/${id}`)
  }
}
