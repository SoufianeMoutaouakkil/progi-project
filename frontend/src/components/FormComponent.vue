<template>
    <form @submit.prevent="submitForm">
        <div>
            <label for="price">Price:</label>
            <input
                type="price"
                v-model="price"
                required
                :class="{ invalid: priceError }"
            />
            <span v-if="priceError" class="error">
                Price must be greater than 0
            </span>
        </div>

        <div>
            <label for="option">Option:</label>
            <select v-model="option" required>
                <option disabled value="">Select an option</option>
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
            price: "",
            option: "",
            loading: false,
            apiResponse: null,
        };
    },
    computed: {
        isValidPrice() {
            return this.price > 0;
        },
        isFormValid() {
            return this.isValidPrice && this.option;
        },
        priceError() {
            return !this.isValidPrice && this.price !== "";
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
                    price: this.price,
                    option: this.option,
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
