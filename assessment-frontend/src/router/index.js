import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue';
import RegisterView from '@/views/RegisterView.vue';
import DashboardView from '@/views/DashboardView.vue';
import CreateCompanyView from '@/views/CreateCompanyView.vue';
import CreateServiceView from '@/views/CreateServiceView.vue';
import UpdateProfile from '@/views/UpdateProfile.vue';
import UpdateCompanyView from '@/views/UpdateCompanyView.vue';
import CompaniesView from '@/views/CompaniesView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    { path: '/dashboard', component: DashboardView, meta: { requiresAuth: true } },
    { path: '/login', component: LoginView },
    { path: '/register', component: RegisterView },
    { path: '/create-company', component: CreateCompanyView, meta: { requiresAuth: true } },
    { path: '/create-service', component: CreateServiceView, meta: { requiresAuth: true } },
    { path: '/update-profile', component: UpdateProfile, meta: { requiresAuth: true } },
    { path: '/update-company/:id', component: UpdateCompanyView, meta: { requiresAuth: true } },
    { path: '/list-companies', component: CompaniesView, meta: { requiresAuth: true } },

  ]
})



router.beforeEach((to, from, next) => {
  const loggedIn = localStorage.getItem('authToken')
  if (to.matched.some(record => record.meta.requiresAuth) && loggedIn === "undefined") {
    next('/login');
  } else {
    next();
  }
});


export default router
