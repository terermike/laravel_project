<template>
  <div class="home col-8 mx-auto py-5 mt-5">
    <h1>Dashboard</h1>
    <div class="card">
      <div class="card-body" v-if="user">
        <!-- <h3>Hello, {{ user.name }}</h3>
        <span>{{ user.email }}</span> -->
        <el-button @click="redirectToProducts" type="primary" class="mt-3">View Products</el-button>
        <el-button @click="redirectToPlaceOrder" type="success" class="mt-3">Place Order</el-button>
      </div>
    </div>
  </div>
</template>

<script>
import User from '../apis/User'

export default {
  data() {
    return {
      user: null
    }
  },

  mounted() {
    User.auth().then((response) => {
      this.user = response.data
    })
  },

  methods: {
    redirectToProducts() {
      this.$router.push({ name: 'products' })
    },
    redirectToPlaceOrder() {
      this.$router.push({ name: 'place-order' }) // Assuming the route name for PlaceOrder is 'place-order'
    }
  }
}
</script>

<style scoped>
/* Add any additional styling here */
</style>
