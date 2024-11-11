<template>
    <form @submit.prevent="submitForm">
        <div>
            <label for="basePrice">Base Price:</label>
            <input
                type="number"
                v-model="basePrice"
                required
                :class="{ invalid: priceError }"
            />
            <span v-if="priceError" class="error">
                Price must be greater than 0
            </span>
        </div>

        <div>
            <label for="vehicleType">Vehicle Type:</label>
            <select v-model="vehicleType" required>
                <option disabled value="">Select the Vehicle Type</option>
                <option value="common">Common</option>
                <option value="luxury">Luxury</option>
            </select>
        </div>

        <button type="submit" :disabled="!isFormValid">Submit</button>
    </form>
</template>

<script>
import vehicleApi from "../apis/vehicle";

export default {
    data() {
        return {
            basePrice: "",
            vehicleType: "",
            loading: false,
            apiResponse: null,
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
    methods: {
        submitForm() {
            if (this.isFormValid) {
                this.fetchVehicleCost();
            }
        },
        async fetchVehicleCost() {
            this.loading = true;

            try {
                this.apiResponse = await vehicleApi.cost({
                    base_price: this.basePrice,
                    vehicle_type: this.vehicleType,
                });
                this.$emit("on-api-res", this.apiResponse);
            } catch (error) {
                console.error("Error fetching vehicle cost:", error);
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.invalid {
    border-color: red;
}
.error {
    color: red;
    font-size: 0.8em;
}
</style>
