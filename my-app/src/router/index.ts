import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ViewZone from '../views/Zone.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/shroomer',
      name: 'shroomer',
      component: Home,
    },
    {
      path: '/zone/:id',
      name: 'zone',
      component: ViewZone,
    },
  ],
})

export default router
