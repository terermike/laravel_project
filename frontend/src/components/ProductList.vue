<template>
  <div>
    <h2>Product List</h2>
    <el-table :data="products" style="width: 100%">
      <el-table-column prop="id" label="ID" min-width="80"></el-table-column>
      <el-table-column prop="name" label="Name" min-width="120"></el-table-column>
      <el-table-column prop="description" label="Description" min-width="200"></el-table-column>
      <el-table-column prop="price" label="Price" min-width="100"></el-table-column>
      <el-table-column prop="quantity" label="Quantity" min-width="100"></el-table-column>
      <!-- <el-table-column label="Actions" min-width="150">
        <template v-slot="scope">
          <el-button type="primary" icon="el-icon-edit" @click="editProduct(scope.row.id)"
            >Edit</el-button
          >
          <el-button type="danger" icon="el-icon-delete" @click="deleteProduct(scope.row.id)"
            >Delete</el-button
          >
        </template>
      </el-table-column> -->
    </el-table>
  </div>
</template>

<script>
import Product from '../apis/Product'

export default {
  data() {
    return {
      products: []
    }
  },
  mounted() {
    this.loadProducts()
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
    editProduct(productId) {
      this.$router.push({ name: 'edit-product', params: { id: productId } })
    },
    async deleteProduct(productId) {
      try {
        await Product.destroy(productId)
        // Reload products after deletion
        this.loadProducts()
        console.log('Product deleted successfully')
      } catch (error) {
        console.error('Error deleting product', error)
      }
    }
  }
}
</script>

<style scoped>
/* Add your custom styles here */
</style>
