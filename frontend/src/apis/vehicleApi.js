import axios from "axios";

const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

const vehicleApi = axios.create({
    baseURL: `${apiUrl}/vehicle/`,
});

export default {
    async cost(params) {
        try {
            if (params.basePrice <= 0 || !params.vehicleType) {
                throw new Error("Invalid input");
            }
            const res = await vehicleApi.get("/cost", {
                params: {
                    base_price: params.basePrice,
                    vehicle_type: params.vehicleType,
                },
            });
            return { isOk: true, data: res.data };
        } catch (error) {
            console.error({ vehiculeapierror: error });
            if (error?.response?.data?.message) {
                return { isOk: false, error: error.response.data.message };
            } else if (error.request) {
                return { isOk: false, error: error.request };
            } else {
                return { isOk: false, error: error.message };
            }
        }
    },
};
