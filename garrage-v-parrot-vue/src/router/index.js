import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    redirect: '/home', // Redirige la route racine vers /home
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },
  {
    path: '/reparations_carroseries',
    name: 'reparations_carroseries',
   
    component: () => import(/* webpackChunkName: "réparations_carrosseries" */ '../views/CarrosseriesView.vue')
  },
  {
    path: '/reparations_mecaniques',
    name: 'reparations_mecaniques',
   
    component: () => import(/* webpackChunkName: "reparations_mecaniques" */ '../views/MecaniquesView.vue')
  },
  {
    path: '/entretiens_vehicules',
    name: 'entretiens_vehicules',
   
    component: () => import(/* webpackChunkName: "reparations_mecaniques" */ '../views/EntretiensView.vue')
  },
  {
    path: '/contact',
    name: 'contact',
   
    component: () => import(/* webpackChunkName: "reparations_mecaniques" */ '../views/ContactView.vue')
  }
 
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
