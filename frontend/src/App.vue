<template>
  <el-container direction="vertical">
    <el-header>
      <el-menu mode="horizontal">
        <el-menu-item index="3" v-if="isLoggedIn">
          <router-link to="/products">View Products</router-link>
        </el-menu-item>
        <el-menu-item index="6" v-if="isLoggedIn">
          <router-link to="/cart">Cart</router-link>
        </el-menu-item>
        <SearchBar v-if="isLoggedIn" slot="end" />
        <el-menu-item index="4" v-if="isLoggedIn">
          <router-link to="/place-order">Orders</router-link>
        </el-menu-item>
        <el-menu-item index="5" v-if="isLoggedIn">
          <el-button @click="logout" type="warning">Logout</el-button>
        </el-menu-item>
      </el-menu>
    </el-header>

    <el-main>
      <router-view v-on:login="handleLogin"></router-view>
    </el-main>
  </el-container>
</template>

<script>
import User from './apis/User'
import UserRegister from './components/UserRegister.vue'
import UserLogin from './components/UserLogin.vue'
import PlaceOrder from './components/PlaceOrder.vue'
import ProductList from './components/ProductList.vue'
import SearchBar from './components/SearchBar.vue'
import CartController from './components/CartController.vue'
import SearchResult from './components/SearchResult.vue'

export default {
  name: 'app',
  components: {
    UserRegister,
    UserLogin,
    PlaceOrder,
    ProductList,
    SearchBar,
    CartController,
    SearchResult
  },
  data() {
    return {
      isLoggedIn: !!localStorage.getItem('token'),
      searchResults: [],
      query: ''
    }
  },
  computed: {
    isRegisterOrLoginPage() {
      return this.$route.path === '/register' || this.$route.path === '/login'
    },
    isCartPage() {
      return this.$route.path === '/cart'
    },
    isProductsPage() {
      return this.$route.path === '/products'
    },
    showSearchResult() {
      // Condition to show SearchResult component based on your requirement
      // For example, you might want to show it only on the products page
      return this.isLoggedIn && this.isProductsPage
    }
  },
  methods: {
    handleLogin() {
      this.isLoggedIn = true
    },
    logout() {
      User.logout().then(() => {
        localStorage.removeItem('token')
        this.isLoggedIn = false
        this.$router.push({ name: 'home' })
      })
    },
    handleSearchResult(products) {
      // Update the search results
      // This could involve setting a data property or calling an API
      console.log(products)
      this.searchResults = products
      this.query = this.searchTerm
    }
  }
}
</script>

<style>
.el-container {
  height: 100vh;
}
.el-header {
  align-items: center;
}
.el-menu {
  display: flex;
  justify-content: space-between;
}
</style>
