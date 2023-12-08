<template>
  <div>
    <el-container>
      <el-main>
        <h1>Welcome to the Home Page!</h1>

        <el-button type="primary" @click="goToRegister">Go to Register Page</el-button>
        <el-button type="success" @click="goToLogin">Go to Login Page</el-button>
      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  methods: {
    goToRegister() {
      this.$router.push('/register')
    },
    goToLogin() {
      this.$router.push('/login')
    }
  }
}
</script>
