import { createApp } from "vue";
import App from "./App.vue";
import "./index.css";
import router from "./router";

import mockServer from "./mocks/mockServer"; // Import the mock server

const isMock =
    process.env.NODE_ENV === "development" &&
    import.meta.env.VITE_MOCK_MODE === "true";

if (isMock) {
    console.log("Starting the mock server");
    mockServer.start();
}

createApp(App).use(router).mount("#app");
