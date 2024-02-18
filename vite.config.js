import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/assets/css/app.css', 'resources/js/user/app.js', 'resources/js/admin/app.js'],
            refresh: true,
        }),
    ],
    resolve: { 
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, './resources'),
            "@assets": path.resolve(__dirname, './resources/assets'),
            "@middleware": path.resolve(__dirname, 'resources/js/user/middleware'),
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@user/components': path.resolve(__dirname, 'resources/js/user/components'),
            "@user/services": path.resolve(__dirname, 'resources/js/user/services'),
            "@user/store": path.resolve(__dirname, './resources/js/user/store'),
            '@admin/components': path.resolve(__dirname, 'resources/js/admin/components'),
            "@admin/services": path.resolve(__dirname, 'resources/js/admin/services'),
            "@admin/store": path.resolve(__dirname, './resources/js/admin/store'),
            '@helpers': path.resolve(__dirname, './resources/js/helpers')
        },
    }
});
