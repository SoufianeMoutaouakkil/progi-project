import { http, HttpResponse } from "msw";
import vehicleServiceMock from "./vehicleServiceMock";

const apiUrl = process.env.REACT_APP_API_URL || "http://localhost:8000";
const vehicleServicePath = `${apiUrl}/api/vehicles`;

export default [
    http.get(`${vehicleServicePath}/cost`, ({ request }) => {
        const url = new URL(request.url);
        const price = url.searchParams.get("price");
        const option = url.searchParams.get("option");

        const costs = vehicleServiceMock.cost({ price: Number(price), option });

        return new HttpResponse(
            JSON.stringify(costs),
            {
                status: 200,
            }
        );
    }),
];
