import Api from './Api'
export default {
  register(form) {
    return Api().post('/auth/register', form)
  },

  login(form) {
    return Api().post('/auth/login', form)
  },

  auth() {
    return Api().get('/user')
  }
}
