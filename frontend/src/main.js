import { createApp } from "vue";
import App from "./App.vue";
import "./index.css";
import router from "./router";

import mockServer from "./mocks/mockServer"; // Import the mock server

// Start the mock service worker (this will intercept API calls in development)
mockServer.start();

createApp(App).use(router).mount("#app");
