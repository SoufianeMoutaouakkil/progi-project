<template>
    <form @submit.prevent="submitForm">
        <div>
            <label for="number">Number:</label>
            <input
                type="number"
                v-model="number"
                required
                :class="{ invalid: numberError }"
            />
            <span v-if="numberError" class="error">
                Number must be greater than 0
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
export default {
    data() {
        return {
            number: "",
            option: "",
        };
    },
    computed: {
        isValidNumber() {
            return this.number > 0;
        },
        isFormValid() {
            return this.isValidNumber && this.option;
        },
        numberError() {
            return !this.isValidNumber && this.number !== "";
        },
    },
    methods: {
        submitForm() {
            this.$emit("on-api-res", {
                number: this.number,
                option: this.option,
            });
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
