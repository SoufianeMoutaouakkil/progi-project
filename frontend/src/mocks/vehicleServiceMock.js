export default {
    cost({ price, option }) {
        if (price <= 0 || !option) {
            throw new Error("Invalid input");
        }
        const basicBuyerFeeCost = basicBuyerFee(price, option);
        const sellerSpecialFeeCost = sellerSpecialFee(price, option);
        const associationCostCost = associationCost(price);

        return {
            option,
            price,
            basicBuyerFee: basicBuyerFeeCost,
            sellerSpecialFee: sellerSpecialFeeCost,
            associationCost: associationCostCost,
            storageFee: 100,
            total:
                basicBuyerFeeCost +
                sellerSpecialFeeCost +
                associationCostCost +
                100 +
                price,
        };
    },
};

const basicBuyerFee = (price, option) => {
    let fee = price * 0.1;
    if (option === "common") {
        fee = Math.min(Math.max(fee, 10), 50);
    } else {
        fee = Math.min(Math.max(fee, 25), 200);
    }
    return Math.round(fee);
};

const sellerSpecialFee = (price, option) => {
    let fee = price * (option === "common" ? 0.02 : 0.04);
    return Math.round(fee);
};

const associationCost = (price) => {
    let cost = 0;
    if (price <= 500) {
        cost = 5;
    } else if (price <= 1000) {
        cost = 10;
    } else if (price <= 3000) {
        cost = 15;
    } else {
        cost = 20;
    }
    return cost;
};
