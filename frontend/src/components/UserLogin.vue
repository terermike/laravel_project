<template>
  <el-form ref="form" :model="form" label-width="120px" size="small">
    <el-form-item label="Email" prop="email" :rules="emailRules">
      <el-input v-model="form.email" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item label="Password" prop="password" :rules="passwordRules">
      <el-input type="password" v-model="form.password" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="login" size="small">login</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import User from '../apis/User'
// import axios from 'axios';
// import Csrf from '../apis/Csrf';

export default {
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      // Validation rules for each form field
      emailRules: [
        { required: true, message: 'Please enter your email', trigger: 'blur' },
        {
          type: 'email',
          message: 'Please enter a valid email address',
          trigger: ['blur', 'change']
        }
      ],
      passwordRules: [{ required: true, message: 'Please enter your password', trigger: 'blur' }]
    }
  },
  methods: {
    async login() {
      try {
        await this.$refs.form.validate() // Validate the form
        const response = await User.login(this.form) // Call the backend API to login
        // Handle the response from the backend
        if (response.status === 200) {
          localStorage.setItem("auth", "true")
          // Login successful, do something (e.g., redirect, show success message)
          console.log('Login successful')
          // this.$router.push({name: "DashBoard"})
        } else if (response.status === 401) {
          // Unauthorized, handle accordingly
          console.log('Invalid email or password')
        } else {
          // Handle other statuses
          console.error('Login failed', response.data)
        }
      } catch (error) {
        // Handle any errors that occurred during the login process
        console.error('Error during login', error)
      }
    }
  }
}
</script>

<style scoped>
.input {
  width: 50%;
}
</style>
