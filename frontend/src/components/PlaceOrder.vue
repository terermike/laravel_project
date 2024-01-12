<template>
  <div>
    <h2>Cart</h2>
    <el-table :data="cartItems" style="width: 100%">
      <el-table-column prop="name" label="Product"></el-table-column>
      <el-table-column prop="pivot.quantity" label="Quantity"></el-table-column>
      <el-table-column prop="pivot.total_price" label="Total Price"></el-table-column>
      <el-table-column label="Actions">
        <template v-slot="scope">
          <el-button type="danger" icon="el-icon-delete" @click="removeFromCart(scope.row.id)"
            >Remove from Cart</el-button
          >
        </template>
      </el-table-column>
    </el-table>
    <el-button type="primary" @click="placeOrder">Place Order</el-button>

    <!-- Display the list of orders -->
    <h2>Order List</h2>
    <el-table :data="orders" style="width: 100%">
      <el-table-column prop="id" label="Order ID" width="80"></el-table-column>
      <el-table-column label="Actions">
        <template v-slot="scope">
          <el-button type="danger" icon="el-icon-delete" @click="deleteOrder(scope.row.id)"
            >Delete</el-button
          >
        </template>
      </el-table-column>
      <el-table-column label="Products">
        <template v-slot="scope">
          <el-table :data="scope.row.products" style="width: 100%">
            <el-table-column prop="name" label="Product"></el-table-column>
            <el-table-column prop="pivot.quantity" label="Quantity"></el-table-column>
            <el-table-column prop="pivot.total_price" label="Total Price"></el-table-column>
          </el-table>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import Cart from '../apis/Cart'
import Order from '../apis/Order'

export default {
  data() {
    return {
      cartItems: [],
      orders: []
    }
  },
  mounted() {
    this.loadCartItems()
    this.loadOrders()
  },
  methods: {
    async loadCartItems() {
      try {
        const response = await Cart.index()
        this.cartItems = response.data.cart.products
      } catch (error) {
        this.$message.error('Error loading cart items')
      }
    },
    async loadOrders() {
      try {
        const response = await Order.index()
        this.orders = response.data.orders
      } catch (error) {
        this.$message.error('Error loading orders')
      }
    },
    async placeOrder() {
      try {
        const response = await Order.store()
        this.$message.success('Order placed successfully')
        this.loadOrders() // Refresh orders after placing order
        this.loadCartItems() // Refresh cart items after placing order
      } catch (error) {
        console.error('Failed to place order', error)
        this.$message.error(`Failed to place order: ${error.response.data.message}`)
      }
    },
    async deleteOrder(orderId) {
      try {
        await Order.destroy(orderId)
        this.loadOrders() // Refresh orders after deletion
        this.$message.success('Order deleted successfully')
      } catch (error) {
        this.$message.error('Error deleting order')
      }
    },
    async removeFromCart(productId) {
      try {
        await Cart.destroy(productId)
        this.loadCartItems() // Refresh cart items after removal
        this.$message.success('Item removed from cart successfully')
      } catch (error) {
        this.$message.error('Error removing item from cart')
      }
    }
  }
}
</script>

<style scoped>
.el-container {
  display: block;
}
</style>
