import { createRouter, createWebHistory } from "vue-router";

import CalculateVehicleCostView from "../views/CalculateVehicleCostView.vue";
import HomeView from "../views/HomeView.vue";

const routes = [
    { path: "/", component: HomeView },
    { path: "/calculate-vehicle-cost", component: CalculateVehicleCostView },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
