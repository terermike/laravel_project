import Api from './Api'
// import Csrf from "./Csrf";
export default {
  register(form) {
    // await Csrf.getCookie();

    return Api().post('/auth/register', form)
  },

  login(form) {
    // await Csrf.getCookie();

    return Api().post('/auth/login', form)
  },
  auth() {
    return Api().get('/user')
  }
}
