<template>
  <div id="app">
    <el-menu mode="horizontal">
      <el-menu-item index="1">
        <router-link to="/register">Register</router-link>
      </el-menu-item>
      <el-menu-item index="2">
        <router-link to="/login">Login</router-link>
      </el-menu-item>
    </el-menu>

    <router-view></router-view>
  </div>
  <!-- <div id="app">
    <router-link to="/register" class="nav-link">Register</router-link>
    <router-link to="/login" class="nav-link">Login</router-link>
    <router-view></router-view>
  </div> -->
</template>

<script>
// import HelloWorld from './components/HelloWorld.vue';
import UserRegister from './components/UserRegister.vue' // Import the UserRegister component
import UserLogin from './components/UserLogin.vue' // Import the UserRegister component

export default {
  name: 'app',
  components: {
    // eslint-disable-next-line vue/no-unused-components
    UserRegister, // Register the UserRegister component
    // eslint-disable-next-line vue/no-unused-components
    UserLogin
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.nav-link {
  color: #42b983;
  font-weight: bold;
  margin-right: 10px;
}
</style>
