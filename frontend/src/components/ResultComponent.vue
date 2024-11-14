<template>
    <div v-if="result?.basePrice !== undefined">
        <v-card class="mx-auto">
            <v-card-title>
                <h1 class="text-h4 font-weight-bold">Vehicle Costs Details</h1>
            </v-card-title>
            <h2>Vehicle Data</h2>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <InfoRow
                            label="Vehicle Base Price"
                            :info="formatPrice(result?.basePrice) + ' $'"
                        />
                    </v-col>
                    <v-col cols="12" md="6">
                        <InfoRow
                            label="Vehicle Type"
                            :info="result?.vehicleType"
                        />
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="6">
                        <h2>Fees details</h2>
                        <InfoRow
                            label="Basic Buyer Fee"
                            :info="
                                formatPrice(result?.fees?.basicBuyerFee) + ' $'
                            "
                        />
                        <InfoRow
                            label="Seller Special Fee"
                            :info="
                                formatPrice(result?.fees?.sellerSpecialFee) +
                                ' $'
                            "
                        />
                        <InfoRow
                            label="Association Fee"
                            :info="
                                formatPrice(result?.fees?.associationFee) + ' $'
                            "
                        />
                        <InfoRow
                            label="Storage Fee"
                            :info="formatPrice(result?.fees?.storageFee) + ' $'"
                        />
                    </v-col>
                    <v-col>
                        <h2>Costs details</h2>
                        <InfoRow
                            label="Total Fees cost"
                            :info="formatPrice(result?.totalFees) + ' $'"
                        />
                        <v-row class="mt-8">
                            <v-col
                                cols="6"
                                class="text-right font-weight-bold text-uppercase text-h6"
                            >
                                Total Vehicle cost with fees:
                            </v-col>
                            <v-col
                                cols="6"
                                class="text-left text-h6 font-weight-bold"
                            >
                                {{ formatPrice(result?.totalPrice) }} $
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import InfoRow from "../customized/data/InfoRow.vue";

export default {
    props: ["result"],
    computed: {
        isResultValid() {
            return this.result?.basePrice !== undefined;
        },
    },
    components: {
        InfoRow,
    },
    methods: {
        formatPrice(price) {
            if (price === undefined) {
                return "--";
            }
            if (isNaN(price) || parseFloat(price) < 0) {
                return "Invalid price (" + price + ") !";
            }
            let integerPart = Math.floor(price);
            let decimalPart = Math.round((price - integerPart) * 100);

            return (
                integerPart.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") +
                "." +
                decimalPart.toString().padEnd(2, "0")
            );
        },
    },
};
</script>
