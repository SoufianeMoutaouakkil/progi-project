<template>
    <v-card class="mx-auto mb-10 pa-5">
        <v-card-title>
            <h1>Vehicle Cost Simulator</h1>
        </v-card-title>

        <v-form @submit.prevent="submitForm">
            <v-text-field
                v-model="basePrice"
                label="Base Price"
                type="number"
                :error-messages="basePriceError"
                id="basePrice"
            ></v-text-field>

            <v-select
                v-model="vehicleType"
                :items="vehicleTypesOptions"
                label="Vehicle Type"
                name="vehicleType"
            ></v-select>

            <v-btn
                type="submit"
                color="primary"
                class="mr-auto"
                :loading="loading"
                :disabled="!isValidForm"
                variant="outlined"
                id="submit-vehicle-data"
            >
                Calculate Costs
            </v-btn>
        </v-form>
        <v-alert
            v-if="apiError && !loading"
            type="error"
            dismissible
            class="mt-5"
            variant="outlined"
            id="vehicle-cost-api-error"
        >
            {{ apiError }}
        </v-alert>
    </v-card>
</template>

<script>
import vehicleApi from "../apis/vehicleApi";

const vehicleTypesOptions = [
    { title: "Common", value: "common" },
    { title: "Luxury", value: "luxury" },
];

export default {
    data() {
        return {
            basePrice: "1000000",
            vehicleType: "luxury",
            basePriceError: "",
            loading: false,
            apiError: null,
            apiResponse: null,
            vehicleTypesOptions,
            isFirstLoad: true,
            isValidPrice: false,
        };
    },
    computed: {
        isValidForm() {
            this.isValidPrice = !isNaN(this.basePrice) && this.basePrice > 0;
            this.basePriceError =
                !this.isValidPrice && this.basePrice !== ""
                    ? "Invalid price"
                    : "";
            return this.isValidPrice && this.vehicleType !== "";
        },
    },
    watch: {
        vehicleType() {
            this.apiError = null;
            if (this.isValidForm && !this.isFirstLoad) {
                this.fetchVehicleCost();
            }
        },
        basePrice() {
            this.isValidPrice = !isNaN(this.basePrice) && this.basePrice > 0;
            this.basePriceError =
                !this.isValidPrice && this.basePrice !== ""
                    ? "Invalid Price"
                    : "";
            if (this.isValidForm && !this.isFirstLoad) {
                this.fetchVehicleCost();
            }
        },
        loading(val) {
            if (val) {
                this.apiError = null;
            }
            if (val && this.apiResponse) {
                this.apiResponse = null;
            }
        },
        apiResponse(val) {
            this.$emit("on-api-res", val);
        },
    },
    methods: {
        submitForm() {
            if (this.isValidForm) {
                this.fetchVehicleCost();
            }
        },
        async fetchVehicleCost() {
            this.isFirstLoad = false;
            this.loading = true;

            const apiCallResponse = await vehicleApi.cost({
                basePrice: this.basePrice,
                vehicleType: this.vehicleType,
            });

            if (apiCallResponse.isOk) {
                this.apiResponse = apiCallResponse.data;
            } else {
                console.error({ error: apiCallResponse.error });
                this.apiError = apiCallResponse.error;
            }

            this.loading = false;
        },
    },
};
</script>
