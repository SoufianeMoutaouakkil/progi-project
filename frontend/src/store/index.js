import { createStore } from "vuex";
import api from "../api/api";

export default createStore({
    state: {
        formData: { number: "", vehicleType: "" },
        apiResponse: null,
    },
    mutations: {
        SET_FORM_DATA(state, payload) {
            state.formData = payload;
        },
        SET_API_RESPONSE(state, response) {
            state.apiResponse = response;
        },
    },
    actions: {
        async submitFormData({ commit, state }) {
            try {
                const response = await api.post("/submit", state.formData);
                commit("SET_API_RESPONSE", response.data);
            } catch (error) {
                console.error(error);
            }
        },
    },
    getters: {
        formData: (state) => state.formData,
        apiResponse: (state) => state.apiResponse,
    },
});
