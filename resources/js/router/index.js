import { createRouter, createWebHistory } from 'vue-router';
import guest from '../middleware/guest';
import auth from '../middleware/auth';
import admin from '../middleware/admin';
import { useUserStore } from '../store/user'
import middlewareController from './middlewareController';

const routes = [
    { path: '/', component: () => import('../pages/Home.vue') },
    { path: '/product/:id', component: () => import('../pages/Product.vue'), props: true },
    { path: '/basket', component: () => import('../pages/Basket.vue') },
    { path: '/profile', component: () => import('../pages/Profile.vue'), meta: { middleware: [auth] } },
    { path: '/admin', component: () => import('../pages/Admin.vue'), meta: { middleware: [admin] } },
    { path: '/login', component: () => import('../pages/Login.vue'), meta: { middleware: [guest] } },
    { path: '/signup', component: () => import('../pages/Signup.vue'), meta: { middleware: [guest] } },
    { path: '/logout', component: () => import('../pages/Logout.vue'), meta: { middleware: [auth] } },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

router.beforeEach(async (to, from, next) => {
    const middleware = to.meta.middleware;
    const store = useUserStore()
    if (!store.$state.isAuth) await store.getUser();
    const context = { from, next, store };

    if (!middleware) return next();

    middleware[0]({
        ...context,
        next: middlewareController(context, middleware)
    })
})

export default router