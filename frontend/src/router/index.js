import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../components/HomePage.vue'
import UserRegister from '../components/UserRegister.vue'
import UserLogin from '../components/UserLogin.vue'
import DashBoard from '../components/DashBoard.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  base: '/',
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomePage
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: UserRegister
    },
    {
      path: '/login',
      name: 'login',
      component: UserLogin
    },
    {
      path:'/dashboard',
      name: 'dashboard',
      component: DashBoard,
      meta: { authOnly: true }
    }
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.authOnly) && !isLoggedIn()) {
    next({name: 'login'});
  } else {
    next();
  }
});

function isLoggedIn() {
  return localStorage.getItem("token");
}


export default router
