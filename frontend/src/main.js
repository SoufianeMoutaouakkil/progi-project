import { createApp } from "vue";
import App from "./App.vue";
import "./index.css";
import router from "./router";

// Vuetify imports
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
    components,
    directives,
});

import mockServer from "./mocks/mockServer";

const isMock =
    process.env.NODE_ENV === "development" &&
    import.meta.env.VITE_MOCK_MODE === "true";

if (isMock) {
    console.log("Starting the mock server");
    mockServer.start();
}

createApp(App).use(router).use(vuetify).mount("#app");
