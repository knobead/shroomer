import { createRouter, createWebHistory } from 'vue-router'
import ViewHome from '../views/ViewHome.vue'
import ViewZone from '../views/ViewZone.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/shroomer',
      name: 'shroomer',
      component: ViewHome,
    },
    {
      path: '/zone/:id',
      name: 'zone',
      component: ViewZone,
    },
  ],
})

export default router
