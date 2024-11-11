import { http, HttpResponse } from "msw";
import vehicleServiceMock from "./vehicleServiceMock";

const apiUrl = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
const vehicleServicePath = `${apiUrl}/vehicle`;

export default [
    http.get(`${vehicleServicePath}/cost`, ({ request }) => {
        const url = new URL(request.url);
        const basePrice = url.searchParams.get("base_price");
        const vehicleType = url.searchParams.get("vehicle_type");

        const costs = vehicleServiceMock.cost({ basePrice: Number(basePrice), vehicleType });

        return new HttpResponse(
            JSON.stringify(costs),
            {
                status: 200,
            }
        );
    }),
];
