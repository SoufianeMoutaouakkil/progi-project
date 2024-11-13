export default {
    cost({ basePrice, vehicleType }) {
        if (basePrice <= 0 || !vehicleType) {
            throw new Error("Invalid input");
        }
        const basicBuyerFeeCost = basicBuyerFee(basePrice, vehicleType);
        const sellerSpecialFeeCost = sellerSpecialFee(basePrice, vehicleType);
        const associationFeeCost = associationFee(basePrice);

        const totalFees =
            basicBuyerFeeCost +
            sellerSpecialFeeCost +
            associationFeeCost +
            100;

        return {
            vehicleType,
            basePrice,
            fees: {
                basicBuyerFee: basicBuyerFeeCost,
                sellerSpecialFee: sellerSpecialFeeCost,
                associationFee: associationFeeCost,
                storageFee: 100,
            },
            totalPrice: basePrice + totalFees,
            totalFees,
        };
    },
};

const basicBuyerFee = (basePrice, vehicleType) => {
    let fee = basePrice * 0.1;
    if (vehicleType === "common") {
        fee = Math.min(Math.max(fee, 10), 50);
    } else {
        fee = Math.min(Math.max(fee, 25), 200);
    }
    return Math.round(fee);
};

const sellerSpecialFee = (basePrice, vehicleType) => {
    let fee = basePrice * (vehicleType === "common" ? 0.02 : 0.04);
    return Math.round(fee);
};

const associationFee = (basePrice) => {
    let cost = 0;
    if (basePrice <= 500) {
        cost = 5;
    } else if (basePrice <= 1000) {
        cost = 10;
    } else if (basePrice <= 3000) {
        cost = 15;
    } else {
        cost = 20;
    }
    return cost;
};
