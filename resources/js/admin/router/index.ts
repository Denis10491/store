import {createRouter, createWebHistory} from 'vue-router';

const basePath = '/admin';
const routes = [
    {
        path: basePath,
        component: () => import('@admin/pages/Home.vue')
    },
    {
        path: basePath + '/products',
        component: () => import('@admin/pages/Products.vue')
    },
    {
        path: basePath + '/orders',
        component: () => import('@admin/pages/Orders.vue')
    },
    {
        path: basePath + '/statistics',
        component: () => import('@admin/pages/Statistics.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router
