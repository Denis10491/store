import { createRouter, createWebHistory } from 'vue-router';

const basePath = '/admin';
const routes = [
    { path: basePath, component: () => import('../pages/Home.vue') },
    { path: basePath+'/products', component: () => import('../pages/Products.vue') },
    { path: basePath+'/orders', component: () => import('../pages/Orders.vue') },
    { path: basePath+'/statistics', component: () => import('../pages/Statistics.vue') }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router