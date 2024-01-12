<template>
  <div>
    <h2>Cart Items</h2>
    <el-table :data="cartItems" style="width: 100%">
      <el-table-column prop="id" label="Product ID" width="80"></el-table-column>
      <el-table-column prop="name" label="Product"></el-table-column>
      <el-table-column prop="pivot.quantity" label="Quantity"></el-table-column>
      <el-table-column label="Actions">
        <template v-slot="scope">
          <el-button type="info" @click="increaseQuantity(scope.$index, scope.row)"
            >Increase</el-button
          >
          <el-button type="info" @click="decreaseQuantity(scope.$index, scope.row)"
            >Decrease</el-button
          >
          <el-button type="danger" @click="removeProduct(scope.$index, scope.row)"
            >Remove</el-button
          >
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import Cart from '../apis/Cart'
import Product from '../apis/Product'

export default {
  data() {
    return {
      cartForm: {
        product_id: null,
        quantity: 1
      },
      products: [],
      cartItems: []
    }
  },
  mounted() {
    this.loadProducts()
    this.loadCartItems()
  },
  methods: {
    async loadProducts() {
      try {
        const response = await Product.index()
        this.products = response.data.products
      } catch (error) {
        this.$message.error('Error loading products')
      }
    },
    async loadCartItems() {
      try {
        const response = await Cart.index()
        this.cartItems = response.data.cart.products
      } catch (error) {
        this.$message.error('Error loading cart items')
      }
    },

    async increaseQuantity(index, row) {
      try {
        console.log('Increasing quantity for product:', row.id)
        this.cartItems[index].pivot.quantity = row.pivot.quantity + 1
        await Cart.updateProduct({
          product_id: row.id,
          quantity: this.cartItems[index].pivot.quantity
        })
        this.loadCartItems()
        this.$message.success('Product quantity updated successfully')
      } catch (error) {
        console.error('Error updating product quantity:', error)
      }
    },
    async decreaseQuantity(index, row) {
      try {
        console.log('row:', row)
        if (row.quantity > 1) {
          this.cartItems[index].pivot.quantity = row.pivot.quantity - 1
          await Cart.updateProduct({
            product_id: row.id,
            quantity: this.cartItems[index].pivot.quantity
          })
          this.loadCartItems()
          this.$message.success('Product quantity updated successfully')
        } else {
          this.$message.error('Quantity cannot be less than 1')
        }
      } catch (error) {
        console.error('Error updating product quantity:', error)
      }
    },
    async removeProduct(index, row) {
      try {
        const payload = { product_id: row.id }
        await Cart.removeProduct(payload)
        this.loadCartItems()
        this.$message.success('Product removed from cart successfully')
      } catch (error) {
        console.error('Error removing product from cart:', error)
        this.$message.error('Error removing product from cart')
      }
    },
    querySearchAsync(queryString, cb) {
      var products = this.products
      var results = queryString ? products.filter(this.createFilter(queryString)) : products
      cb(results)
    },
    createFilter(queryString) {
      return (product) => {
        return product.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
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
