import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '../components/HomePage.vue'
import UserRegister from '../components/UserRegister.vue'
import UserLogin from '../components/UserLogin.vue'
import DashBoard from '../components/DashBoard.vue'
import ProductList from '../components/ProductList.vue'
import PlaceOrder from '../components/PlaceOrder.vue'
import CartController from '../components/CartController.vue'
import SearchBar from '../components/SearchBar.vue'
import SearchResult from '../components/SearchResult.vue'

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
    },
    {
      path: '/products',
      name: 'products',
      component: ProductList // Route for the ProductList component
    },
    {
      path: '/place-order',
      name: 'place-order',
      component: PlaceOrder
      // children: [
      //   {
      //     path: 'search',
      //     name: 'search',
      //     components: {
      //       // Nested route for SearchBar and SearchResult
      //       default: SearchBar,
      //       result: SearchResult
      //     }
      //   }
      // ]
    },
    {
      path: '/cart',
      name: 'cart',
      component: CartController
    },
    {
      path: '/search/:query',
      name: 'SearchResult',
      component: SearchResult,
      props: true
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.authOnly) && !isLoggedIn()) {
    next({ name: 'login' })
  } else if (
    (to.name === 'products' || to.name === 'place-order' || to.name === 'search') &&
    !isLoggedIn()
  ) {
    // Redirect to login if not logged in when trying to access products, place an order, or perform a search
    next({ name: 'login' })
  } else {
    next()
  }
})

function isLoggedIn() {
  return localStorage.getItem('token')
}

export default router
