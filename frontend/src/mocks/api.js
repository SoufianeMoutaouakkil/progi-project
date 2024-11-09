export function getVehicleCost(number, option) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (number <= 0 || !option) {
                reject("Invalid input"); // Simulate an error
            } else {
                resolve({
                    cost: number * (option === "luxury" ? 2 : 1),
                    option: option,
                });
            }
        }, 1500); // Simulated delay of 1.5 seconds
    });
}
