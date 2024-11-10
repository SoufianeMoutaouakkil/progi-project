<template>
    <h1>Calculate Vehicle Cost</h1>
    <div v-if="result?.price !== undefined">
        <p>Price: {{ result.price }}</p>
        <p>Option: {{ result.option }}</p>
        <p>Basic buyer fee: {{ result.basicBuyerFee }}</p>
        <p>Seller special fee: {{ result.sellerSpecialFee }}</p>
        <p>Association cost: {{ result.associationCost }}</p>
        <p>Storage fee: {{ result.storageFee }}</p>
        <p>Total: {{ result.total }}</p>
    </div>
</template>

<script>
console.log("ResultComponent.vue");

export default {
    props: ["result"],
    computed: {
        isResultValid() {
            console.log({ price: this.result?.price });
            return this.result && this.result.price;
        },
    },
};
</script>
