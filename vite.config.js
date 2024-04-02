import {defineConfig} from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "node:path";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                "resources/assets/css/app.css",
                "resources/js/user/app.ts",
                "resources/js/admin/app.ts",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@assets": path.resolve(__dirname, "./resources/assets"),
            "@helpers": path.resolve(__dirname, "./resources/js/helpers"),
            "@ui": path.resolve(__dirname, "./resources/js/ui"),
            "@components": path.resolve(__dirname, "./resources/js/components"),
            "@user": path.resolve(__dirname, "./resources/js/user"),
            "@admin": path.resolve(__dirname, "./resources/js/admin"),
        },
    },
});
