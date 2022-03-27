import { createRouter, createWebHistory } from 'vue-router'
import Login from './pages/Login';
import Register from './pages/Register';
import Dashboard from './pages/Dashboard';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        meta: {requiresAuth: true}
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { noAuth: true }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { noAuth: true }
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;