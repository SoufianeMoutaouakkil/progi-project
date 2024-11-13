import "vuetify/styles";
import { createVuetify } from "vuetify";
// router dependencies
import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import CalculateVehicleCostView from "@/views/CalculateVehicleCostView.vue";

export const vuetify = createVuetify();

const routes = [
    {
        path: "/",
        component: HomeView,
    },
    {
        path: "/calculate-vehicle-cost",
        component: CalculateVehicleCostView,
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
