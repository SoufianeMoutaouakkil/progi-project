<template>
    <div v-if="result?.basePrice !== undefined">
        <v-card class="mx-auto">
            <v-card-title>
                <h1>Vehicle Cost Simulator Results</h1>
            </v-card-title>
            <h2>Vehicle Data</h2>
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <InfoRow
                            label="Vehicle Base Price"
                            :info="result?.basePrice + ' $'"
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
                            :info="result?.fees?.basicBuyerFee + ' $'"
                        />
                        <InfoRow
                            label="Seller Special Fee"
                            :info="result?.fees?.sellerSpecialFee + ' $'"
                        />
                        <InfoRow
                            label="Association Fee"
                            :info="result?.fees?.associationFee + ' $'"
                        />
                        <InfoRow
                            label="Storage Fee"
                            :info="result?.fees?.storageFee + ' $'"
                        />
                    </v-col>
                    <v-col>
                        <h2>Costs details</h2>
                        <InfoRow
                            label="Total Fees cost"
                            :info="result?.totalFees + ' $'"
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
                                {{ result?.totalPrice }} $
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
};
</script>
