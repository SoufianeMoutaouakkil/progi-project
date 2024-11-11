export function getVehicleCost(basePrice, vehicleType) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (basePrice <= 0 || !vehicleType) {
                reject("Invalid input"); // Simulate an error
            } else {
                resolve({
                    cost: basePrice * (vehicleType === "luxury" ? 2 : 1),
                    vehicleType: vehicleType,
                });
            }
        }, 1500); // Simulated delay of 1.5 seconds
    });
}
