import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/public/HomeView.vue';

const routes = [
  {
    path: '/',
    redirect: '/home', // Redirige la route racine vers /home
  },
  {
    path: '/admin', 
    redirect: '/admin-connexion', // Redirige la route racine vers /home
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },
  {
    path: '/reparations_carroseries',
    name: 'reparations_carroseries',
   
    component: () => import(/* webpackChunkName: "réparations_carrosseries" */ '../views/public/CarrosseriesView.vue')
  },
  {
    path: '/reparations_mecaniques',
    name: 'reparations_mecaniques',
   
    component: () => import(/* webpackChunkName: "reparations_mecaniques" */ '../views/public/MecaniquesView.vue')
  },
  {
    path: '/entretiens_vehicules',
    name: 'entretiens_vehicules',
   
    component: () => import(/* webpackChunkName: "entretiens_véhicules" */ '../views/public/EntretiensView.vue')
  },
  {
    path: '/contact',
    name: 'contact',
   
    component: () => import(/* webpackChunkName: "contact" */ '../views/public/ContactView.vue')
  },
  {
    path: '/gallerie',
    name: 'gallerie',
   
    component: () => import(/* webpackChunkName: "galleries-de-véhicules" */ '../views/public/VentesView.vue')
  },

  ///////////////////////         partie administration         ///////////////////////

  
  ////////////////////// error 404 ////////////////////////
  {
    path: '/:catchAll(.*)',
    name: '404',
    component: () => import(/* webpackChunkName: "erreur404" */ '@/views/public/NotFoundView.vue')
  },
 
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})
//creer les routes admins securisées

export default router
