<template>
    <h1>Calculate Vehicle Cost</h1>
    <div v-if="result?.basePrice !== undefined">
        <p>Base Price: {{ result.basePrice }}</p>
        <p>Vehicle Type: {{ result.vehicleType }}</p>
        <p>Basic buyer fee: {{ result?.fees?.basicBuyerFee }}</p>
        <p>Seller special fee: {{ result?.fees?.sellerSpecialFee }}</p>
        <p>Association cost: {{ result?.fees?.associationCost }}</p>
        <p>Storage fee: {{ result?.fees?.storageFee }}</p>
        <p>Total Price: {{ result.totalPrice }}</p>
    </div>
</template>

<script>
export default {
    props: ["result"],
    computed: {
        isResultValid() {
            return this.result && this.result.basePrice;
        },
    },
};
</script>
