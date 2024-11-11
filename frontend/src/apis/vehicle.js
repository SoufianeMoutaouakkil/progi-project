import axios from "axios";

const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

const vehicleApi = axios.create({
    baseURL: `${apiUrl}/vehicle/`,
});

export default {
    async cost(params) {
        const res =  await vehicleApi.get("/cost", { params });
        return res.data;
    },
};
