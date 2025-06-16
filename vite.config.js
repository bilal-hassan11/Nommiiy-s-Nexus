import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import * as path from "path"; // Import path using ES module syntax
import vueDevTools from "vite-plugin-vue-devtools";

export default defineConfig({
    plugins: [
        vue(),
        vueDevTools(),
        laravel({
            input: ["resources/css/main.css", "resources/js/main.js"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": path.resolve(__dirname, "resources/js"), // Adjust @ alias for your project structure
        },
    },
});
