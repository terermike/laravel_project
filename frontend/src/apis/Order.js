import Api from './Api'

export default {
  // Get all orders
  index() {
    return Api().get('/orders')
  },

  // Create a new order
  store(form) {
    return Api().post('/orders', form)
  },

  // Update an existing order
  update(id, form) {
    return Api().put(`/orders/${id}`, form)
  },

  // Delete an order
  destroy(id) {
    return Api().delete(`/orders/${id}`)
  }
}
