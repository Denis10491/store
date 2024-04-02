import {createRouter, createWebHistory} from 'vue-router';
import guest from '@user/router/middleware/guest';
import auth from '@user/router/middleware/auth';
import middlewareController from '@user/router/middlewareController';

const routes = [
    {
        path: '/',
        component: () => import('@user/pages/Home.vue')
    },
    {
        path: '/product/:id',
        component: () => import('@user/pages/Product.vue'),
        props: true
    },
    {
        path: '/basket',
        component: () => import('@user/pages/Basket.vue')
    },
    {
        path: '/profile',
        component: () => import('@user/pages/Profile.vue'),
        meta: {middleware: [auth]}
    },
    {
        path: '/about',
        component: () => import('@user/pages/About.vue')
    },
    {
        path: '/login',
        component: () => import('@user/pages/auth/Login.vue'),
        meta: {middleware: [guest]}
    },
    {
        path: '/signup',
        component: () => import('@user/pages/auth/Signup.vue'),
        meta: {middleware: [guest]}
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

router.beforeEach((to, from, next) => {
    const middleware = to.meta.middleware;
    const context = {from, next};

    if (!middleware) {
        return next();
    }

    middleware[0]({
        ...context,
        next: middlewareController(context, middleware)
    })
})

export default router
