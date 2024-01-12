<!-- SearchBar.vue -->
<template>
  <div>
    <el-input
      v-model="searchTerm"
      placeholder="Search products"
      @input="debouncedSearch"
    ></el-input>
  </div>
</template>

<script>
import { ref } from 'vue'
import Product from '../apis/Product'
import _ from 'lodash'

export default {
  data() {
    return {
      searchTerm: '',
      loading: false
    }
  },
  methods: {
    async debouncedSearch() {
      // Debounce the search function
      _.debounce(this.searchProducts, 300)()
    },
    async searchProducts() {
      if (this.searchTerm.length > 2) {
        try {
          this.loading = true
          // Fetch search results based on the searchTerm
          // Replace this with your actual API call to retrieve search results
          const response = await Product.search(this.searchTerm)
          // Emit the search results to the parent component
          // this.$emit('search-result', response.data.products)
          this.$router.push({ name: 'SearchResult', params: { query: this.searchTerm } })
        } catch (error) {
          console.error('Error searching products', error)
          this.$message.error('Error searching products. Please try again.')
        } finally {
          this.loading = false
        }
      }
    }
  }
}
</script>

<style scoped>
/* Add your custom styles here */
</style>
