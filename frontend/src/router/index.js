import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../components/HomePage.vue'
import UserRegister from '../components/UserRegister.vue'
import UserLogin from '../components/UserLogin.vue'
import DashBoard from '../components/DashBoard.vue'
import ProductList from '../components/ProductList.vue'
import PlaceOrder from '../components/PlaceOrder.vue'

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
      path: '/dashboard',
      name: 'dashboard',
      component: DashBoard,
      meta: { authOnly: true }
      // children: [
      //   {
      //     path: '/place-order', // Child route for PlaceOrder component
      //     name: 'place-order',
      //     component: PlaceOrder
      //   }
      // ]
    },
    {
      path: '/products',
      name: 'products',
      component: ProductList // add a route for the ProductList component
    },
    {
      path: '/place-order', // Child route for PlaceOrder component
      name: 'place-order',
      component: PlaceOrder
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.authOnly) && !isLoggedIn()) {
    next({ name: 'login' })
  } else if ((to.name === 'products' || to.name === 'place-order') && !isLoggedIn()) {
    // Redirect to login if not logged in when trying to access products or place an order
    next({ name: 'login' })
  } else {
    next()
  }
})

function isLoggedIn() {
  return localStorage.getItem('token')
}

export default router
