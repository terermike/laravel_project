<template>
  <el-form ref="form" :model="form" label-width="120px" size="small">
    <el-form-item label="Email" prop="email" :rules="emailRules">
      <el-input v-model="form.email" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item label="Password" prop="password" :rules="passwordRules">
      <el-input type="password" v-model="form.password" class="input" size="small"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click.prevent="login" size="small">login</el-button>
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
    login() {
        this.$refs.form.validate(); // Validate the form
       User.login(this.form)
        .then(response => {
          this.$root.$emit("login", true);
          localStorage.setItem("token", response.data.remember_token);
          this.$router.push({name: "dashboard"});
        })
      .catch (error => {
        console.log(error);
      });
    }
  }
}
</script>

<style scoped>
.input {
  width: 50%;
}
</style>
