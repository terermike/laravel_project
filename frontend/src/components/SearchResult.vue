<template>
  <div>
    <h2>Search Results for "{{ query }}"</h2>

    <el-table :data="searchResults" style="width: 100%">
      <el-table-column prop="id" label="Product ID" width="80"></el-table-column>
      <el-table-column prop="name" label="Product"></el-table-column>
      <el-table-column prop="description" label="Description"></el-table-column>
      <el-table-column prop="price" label="Price"></el-table-column>
      <el-table-column label="Quantity">
        <template v-slot="scope">
          <el-input
            v-model="scope.row.cartQuantity"
            type="number"
            :min="1"
            @input="validateQuantity(scope.row)"
          ></el-input>
        </template>
      </el-table-column>
      <el-table-column label="Actions">
        <template v-slot="scope">
          <el-button
            type="primary"
            :disabled="!isValidQuantity(scope.row)"
            @click="addProductToCart(scope.row)"
          >
            Add to Cart
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import Cart from '../apis/Cart'
import Product from '../apis/Product'

export default {
  props: ['query'],
  data() {
    return {
      searchResults: []
    }
  },
  watch: {
    query: {
      immediate: true,
      async handler(newQuery) {
        // Fetch search results based on the new query
        try {
          const response = await Product.search(newQuery)
          this.searchResults = response.data.products.map((product) => ({
            ...product,
            cartQuantity: 1 // Initialize cartQuantity to 1 for each product
          }))
        } catch (error) {
          console.error('Error fetching search results', error)
        }
      }
    }
  },
  methods: {
    async addProductToCart(product) {
      try {
        // Use the product's id and cartQuantity for adding to the cart
        await Cart.addProduct({ product_id: product.id, quantity: product.cartQuantity })
        this.$message.success('Product added to cart successfully')
        console.log('Product added to cart successfully')
      } catch (error) {
        console.error('Error adding product to cart', error)
        this.$message.error('Error adding product to cart. Please try again.')
      }
    },
    validateQuantity(product) {
      product.cartQuantity = Math.max(1, Math.floor(product.cartQuantity))
    },
    isValidQuantity(product) {
      return product.cartQuantity >= 1
    }
  }
}
</script>

<style scoped>
/* Add your custom styles here */
</style>
