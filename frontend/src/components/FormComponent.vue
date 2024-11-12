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
                @change="onBasePriceChange"
            ></v-text-field>

            <v-select
                v-model="vehicleType"
                :items="vehicleTypesOptions"
                label="Select Vehicle Type"
            ></v-select>

            <v-btn
                type="submit"
                color="primary"
                class="mr-auto"
                :loading="loading"
                :disabled="!isFormValid"
                variant="outlined"
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
        >
            {{ apiError }}
        </v-alert>
    </v-card>
</template>

<script>
import vehicleApi from "../apis/vehicle";

const vehicleTypesOptions = [
    { title: "Common", value: "common" },
    { title: "Luxury", value: "luxury" },
];

export default {
    data() {
        return {
            basePrice: "398",
            vehicleType: "common",
            basePriceError: "",
            loading: false,
            apiError: null,
            apiResponse: null,
            vehicleTypesOptions,
        };
    },
    computed: {
        isValidPrice() {
            return this.basePrice > 0;
        },
        isFormValid() {
            return this.isValidPrice && this.vehicleType;
        },
        priceError() {
            return !this.isValidPrice && this.basePrice !== "";
        },
    },
    watch: {
        vehicleType() {
            this.apiError = null;
            if (this.isFormValid) {
                this.fetchVehicleCost();
            }
        },
        basePrice() {
            this.basePriceError = this.priceError ? "Invalid price" : "";
        },
    },
    methods: {
        submitForm() {
            if (this.isFormValid) {
                this.fetchVehicleCost();
            }
        },
        onBasePriceChange() {
            if (this.isFormValid) {
                this.fetchVehicleCost();
            }
        },
        async fetchVehicleCost() {
            this.loading = true;
            this.apiError = null;

            this.$emit("on-api-res", null);

            try {
                this.apiResponse = await vehicleApi.cost({
                    base_price: this.basePrice,
                    vehicle_type: this.vehicleType,
                });
                this.$emit("on-api-res", this.apiResponse);
            } catch (error) {
                this.apiError = error?.response?.data?.message || error.message;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
