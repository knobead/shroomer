import { createRouter, createWebHistory } from 'vue-router'
import ViewShroomerHome from '../views/ShroomerHome.vue'
import ViewZones from '../views/Zones.vue'
import ViewZone from '../views/Zone.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/shroomer',
      name: 'shroomer',
      component: ViewShroomerHome,
    },
    {
      path: '/zones',
      name: 'zones',
      component: ViewZones,
    },
    {
      path: '/zone/:id',
      name: 'zone',
      component: ViewZone,
    },
  ],
})

export default router
