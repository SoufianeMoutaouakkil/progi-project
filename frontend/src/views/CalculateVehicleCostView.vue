<template>
    <div>
        <h1>Calculate Vehicle Cost</h1>
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
            console.log("Setting API result:", data);
            this.apiResult = data;
        },
    },
};
</script>
