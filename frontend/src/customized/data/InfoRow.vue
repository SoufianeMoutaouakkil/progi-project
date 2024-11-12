<template>
    <v-row class="mt-2">
        <v-col :cols="labelCols" :class="labelClass"> {{ label }}: </v-col>
        <v-col :cols="infoCols" :class="infoClass">
            {{ info }}
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        info: {
            type: String,
            required: true,
        },
        labelCols: {
            type: String,
            default: "6",
        },
        infoCols: {
            type: String,
            default: "6",
        },
        labelClass: {
            type: String,
            default: "text-right font-weight-bold text-uppercase",
        },
        infoClass: {
            type: String,
            default: "text-left",
        },
    },
};
</script>
