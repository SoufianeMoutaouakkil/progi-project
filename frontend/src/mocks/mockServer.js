import { setupWorker } from "msw/browser";
import vehicleHandlers from "./vehicleHandlers";

export default setupWorker(...vehicleHandlers);
