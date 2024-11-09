<template>
    <div>
        <h1>Calculate Vehicle Cost</h1>
        <FormComponent @on-api-res="setApiResult" />
        <ResultComponent :result="apiResult" v-if="apiResult" />
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
