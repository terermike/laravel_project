<template>
  <el-container>
    <div id="app">
      <el-header>
        <el-menu mode="horizontal" style="width: 300px;">
          <el-menu-item index="1" v-if="!isHomePage">
            <router-link to="/register">Register</router-link>
          </el-menu-item>
          <el-menu-item index="2" v-if="!isHomePage">
            <router-link to="/login">Login</router-link>
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
import UserRegister from './components/UserRegister.vue';
import UserLogin from './components/UserLogin.vue';

export default {
  name: 'app',
  components: {
    UserRegister,
    UserLogin
  },
  computed: {
    isHomePage() {
      return this.$route.path === '/';
    }
  }
};
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
.container {
  max-width: 1200px;
  margin: auto;
}
.el-main {
  background: #eef1f4;
}
</style>
