import { defineConfig } from "vite";
import { fileURLToPath, URL } from "url";
import vue from "@vitejs/plugin-vue";
import vuetify from "vite-plugin-vuetify";

export default defineConfig({
    plugins: [vue(), vuetify({ autoImport: true })],
    optimizeDeps: {
        include: ["vuetify"], // Ensures Vuetify is pre-bundled
    },
    test: {
        globals: true,
        environment: "jsdom",
        server: {
            deps: {
                inline: ["vuetify"],
            },
        },
    },
    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./src", import.meta.url)),
        },
    },
});
