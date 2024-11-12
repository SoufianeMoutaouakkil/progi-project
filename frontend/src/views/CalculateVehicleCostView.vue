<template>
    <div>
        <div style="display: flex; justify-content: flex-start">
            <router-link to="/" style="text-decoration: none; color: inherit">
                <v-btn class="mb-4" color="primary" variant="outlined">
                    <
                </v-btn>
            </router-link>
        </div>
        <FormComponent @on-api-res="setApiResult" />
        <ResultComponent :result="apiResult" />
    </div>
</template>

<script>
import FormComponent from "../components/FormComponent.vue";
import ResultComponent from "../components/ResultComponent.vue";

export default {
    components: {
        FormComponent,
        ResultComponent,
    },
    data() {
        return {
            apiResult: null,
        };
    },
    methods: {
        setApiResult(data) {
            this.apiResult = data;
        },
    },
};
</script>
