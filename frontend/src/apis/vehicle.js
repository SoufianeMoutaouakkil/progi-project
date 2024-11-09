import axios from "axios";

const apiUrl = process.env.REACT_APP_API_URL || "http://localhost:8000";

const vehicleApi = axios.create({
    baseURL: `${apiUrl}/api/vehicles/`,
});

export default {
    async cost(params) {
        const res =  await vehicleApi.get("/cost", { params });
        return res.data;
    },
};
