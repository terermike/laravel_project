<template>
  <!-- <div class="login-dash"> -->
  <el-form ref="form" :model="form" label-width="120px" size="small">
    <el-form-item label="Name" prop="name" :rules="nameRules">
      <el-input v-model="form.name" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item label="Email" prop="email" :rules="emailRules">
      <el-input v-model="form.email" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item label="Password" prop="password" :rules="passwordRules">
      <el-input type="password" v-model="form.password" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item label="Confirm Password" prop="confirmPassword" :rules="confirmPasswordRules">
      <el-input
        type="password"
        v-model="form.confirmPassword"
        class="input"
        size="small"
      ></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="register" size="small">Register</el-button>
    </el-form-item>
  </el-form>
  <!-- </div> -->
</template>

<script>
import User from '../apis/User'
// import axios from 'axios';
// import Csrf from '../apis/Csrf';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: ''
      },
      // Validation rules for each form field
      nameRules: [{ required: true, message: 'Please enter your name', trigger: 'blur' }],
      emailRules: [
        { required: true, message: 'Please enter your email', trigger: 'blur' },
        {
          type: 'email',
          message: 'Please enter a valid email address',
          trigger: ['blur', 'change']
        }
      ],
      passwordRules: [{ required: true, message: 'Please enter your password', trigger: 'blur' }],
      confirmPasswordRules: [
        { required: true, message: 'Please confirm your password', trigger: 'blur' },
        { validator: this.validatePasswordMatch, trigger: 'blur' }
      ]
    }
  },
  methods: {
    validatePasswordMatch(rule, value) {
      return new Promise((resolve, reject) => {
        if (value !== this.form.password) {
          reject(new Error('Passwords do not match'))
        } else {
          resolve()
        }
      })
    },
    async register() {
      try {
        // Step 1: Validate the form
        await this.$refs.form.validate()
        // Step 2: If validation passes, call the backend API to register the user
        User.register(this.form)
          .then((response) => {
            if (response.status === 200) {
              this.$router.push({ name: 'login' })
              console.log('Registartion successful')
            }
          })
          .catch((error) => {
            // Step 3: Handle errors from the backend
            if (error.response && error.response.status === 401) {
              // If the error is about the email being taken, show a specific message
              if (error.response.data.status === false && error.response.data.errors.email) {
                this.$message.error(error.response.data.errors.email[0])
              }
            } else {
              // For other errors, just log them
              console.error('Registration failed', error.response.data)
            }
          })
      } catch (error) {
        // Handle any errors that occurred during the registration process
        console.error('Rada chafu', error)
      }
    }
  }
}
</script>

<style scoped>
.input {
  width: 50%;
}
/* .login-dash {
  background: F0FFFF;
} */
</style>
