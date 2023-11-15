<template>
  <el-form ref="form" :model="form" label-width="120px">
    <el-form-item label="Name" prop="name" :rules="nameRules">
      <el-input v-model="form.name"></el-input>
    </el-form-item>
    <el-form-item label="Email" prop="email" :rules="emailRules">
      <el-input v-model="form.email"></el-input>
    </el-form-item>
    <el-form-item label="Password" prop="password" :rules="passwordRules">
      <el-input type="password" v-model="form.password"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="register">Register</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import User from "../apis/User";
// import axios from 'axios';
import Csrf from '../apis/Csrf';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: ''
      },
      // Validation rules for each form field
      nameRules: [
        { required: true, message: 'Please enter your name', trigger: 'blur' },
        // Add more rules as needed
      ],
      emailRules: [
        { required: true, message: 'Please enter your email', trigger: 'blur' },
        { type: 'email', message: 'Please enter a valid email address', trigger: ['blur', 'change'] },
        // Add more rules as needed
      ],
      passwordRules: [
        { required: true, message: 'Please enter your password', trigger: 'blur' },
        // Add more rules as needed
      ],
    };
  },
  methods: {
    register() {
      Csrf.getCookie().then(()=>{
        User.register(this.form);
      });
    }
  }
};
</script>

<style scoped>
/* Add scoped styles if needed */
</style>
