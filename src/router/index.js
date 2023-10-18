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

  {
    path: '/admin-connexion',
    name: '/admin-connexion',
   
    component: () => import(/* webpackChunkName: "admin-connexion" */ '@/views/admin/ConnectView.vue')
  },
  {
    path: '/admin/dashboard',
    name: 'dashboard',
   
    component: () => import(/* webpackChunkName: "dashboard" */ '@/views/admin/DashboardView.vue')
  },
  {
    path: '/admin/gestion-vehicules',
    name: 'gestion-vehicules',
   
    component: () => import(/* webpackChunkName: "gestion-vehicules" */ '@/views/admin/AdminCars.vue')
  },
  {
    path: '/admin/gestion-commentaires',
    name: 'gestion-commentaires',
   
    component: () => import(/* webpackChunkName: "gestion-commentaires" */ '@/views/admin/AdminComments.vue')
  },
  {
    path: '/admin/gestion-messages',
    name: 'gestion-messages',
   
    component: () => import(/* webpackChunkName: "gestion-messages" */ '@/views/admin/AdminMessages.vue')
  },
  {
    path: '/admin/gestion-staff',
    name: 'gestion-staff',
   
    component: () => import(/* webpackChunkName: "gestion-staff" */ '@/views/admin/AdminStaff.vue')
  },

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
