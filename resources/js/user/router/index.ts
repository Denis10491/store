import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '../store/user'
import guest from '../middleware/guest';
import auth from '../middleware/auth';
import middlewareController from './middlewareController';
import { setAuthorizationToken } from '../services/auth';

const routes = [
    { path: '/', component: () => import('../pages/Home.vue') },
    { path: '/product/:id', component: () => import('../pages/Product.vue'), props: true },
    { path: '/basket', component: () => import('../pages/Basket.vue') },
    { path: '/profile', component: () => import('../pages/Profile.vue'), meta: { middleware: [auth] } },
    { path: '/about', component: () => import('../pages/About.vue') },
    { path: '/login', component: () => import('../pages/Login.vue'), meta: { middleware: [guest] } },
    { path: '/signup', component: () => import('../pages/Signup.vue'), meta: { middleware: [guest] } }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

router.beforeEach((to, from, next) => {
    const middleware = to.meta.middleware;

    setAuthorizationToken('Bearer ' + sessionStorage.getItem('token') ?? '');

    const store = useUserStore();
    store.getUserInfo().then(isAuthStatus => {
        const context = { from, next, isAuthStatus };
        if (!middleware) return next();
        middleware[0]({
            ...context,
            next: middlewareController(context, middleware)
        })
    });
})

export default router