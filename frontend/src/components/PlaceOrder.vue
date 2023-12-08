<template>
  <div>
    <h2>Place Order</h2>
    <el-form :model="orderForm" label-width="80px">
      <el-form-item label="Product">
        <!-- Select product from a list -->
        <el-select v-model="orderForm.product_id" placeholder="Select a product">
          <el-option
            v-for="product in products"
            :key="product.id"
            :label="product.name"
            :value="product.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Quantity" label-width="80px">
        <!-- Input for order quantity -->
        <el-input v-model="orderForm.quantity" type="number" :min="1" />
      </el-form-item>
      <el-form-item>
        <!-- Button to submit the order -->
        <el-button type="primary" @click="placeOrder">Place Order</el-button>
      </el-form-item>
    </el-form>

    <!-- Display the list of orders -->
    <h2>Order List</h2>
    <el-table :data="orders" style="width: 100%">
      <el-table-column prop="id" label="Order ID" width="80"></el-table-column>
      <el-table-column prop="name" label="Product"></el-table-column>
      <el-table-column prop="quantity" label="Quantity"></el-table-column>
      <el-table-column label="Actions">
        <template v-slot="scope">
          <el-button type="danger" icon="el-icon-delete" @click="deleteOrder(scope.row.id)"
            >Delete</el-button
          >
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import Order from '../apis/Order'
import Product from '../apis/Product'

export default {
  data() {
    return {
      orderForm: {
        product_id: null,
        quantity: 1
      },
      products: [],
      orders: []
    }
  },
  mounted() {
    this.loadProducts()
    this.loadOrders()
  },
  methods: {
    async loadProducts() {
      try {
        const response = await Product.index()
        this.products = response.data.products // Set this.products to the 'products' array
      } catch (error) {
        console.error('Error loading products', error)
      }
    },
    async loadOrders() {
      try {
        const response = await Order.index()
        this.orders = response.data.orders // Set this.orders to the 'orders' array
      } catch (error) {
        console.error('Error loading orders', error)
      }
    },
    async placeOrder() {
      try {
        await Order.store(this.orderForm)
        // Reload orders after placing an order
        this.loadOrders()
        // Reset the form
        this.orderForm = {
          product_id: null,
          quantity: 1
        }
        console.log('Order placed successfully')
      } catch (error) {
        console.error('Error placing order', error)
      }
    },
    async deleteOrder(orderId) {
      try {
        await Order.destroy(orderId)
        // Reload orders after deletion
        this.loadOrders()
        console.log('Order deleted successfully')
      } catch (error) {
        console.error('Error deleting order', error)
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
