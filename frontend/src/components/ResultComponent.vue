<template>
    <div v-if="result.number">
        <p>Number: {{ result.number }}</p>
        <p>Option: {{ result.option }}</p>
    </div>
</template>

<script>
export default {
    props: ["result"],
};
</script>
