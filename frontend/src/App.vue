<template>
  <el-container>
    <div id="app">
      <el-header>
        <el-menu mode="horizontal" style="width: 300px">
          <el-menu-item index="1" v-if="isRegisterOrLoginPage">
            <router-link to="/register">Register</router-link>
          </el-menu-item>
          <el-menu-item index="2" v-if="isRegisterOrLoginPage">
            <router-link to="/login">Login</router-link>
          </el-menu-item>
          <el-menu-item index="3" v-if="isPlaceOrderPage">
            <router-link to="/products">View Products</router-link>
          </el-menu-item>
          <el-menu-item index="4" v-if="isProductsPage">
            <router-link to="/place-order">Place Order</router-link>
          </el-menu-item>
        </el-menu>
      </el-header>
      <el-main>
        <router-view></router-view>
      </el-main>
    </div>
  </el-container>
</template>

<script>
import UserRegister from './components/UserRegister.vue'
import UserLogin from './components/UserLogin.vue'
import PlaceOrder from './components/PlaceOrder.vue'
import ProductList from './components/ProductList.vue'

export default {
  name: 'app',
  components: {
    UserRegister,
    UserLogin,
    PlaceOrder,
    ProductList
  },
  computed: {
    isRegisterOrLoginPage() {
      return this.$route.path === '/register' || this.$route.path === '/login'
    },
    isPlaceOrderPage() {
      return this.$route.path === '/place-order'
    },
    isProductsPage() {
      return this.$route.path === '/products'
    }
  }
}
</script>

<style>
/* #app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
} */
.nav-link {
  color: #42b983;
  font-weight: bold;
  margin-right: 10px;
}
.el-main {
  background: #eef1f4;
}
</style>
