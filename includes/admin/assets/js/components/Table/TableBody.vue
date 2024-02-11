<template>
    <tbody>
        <Row :headers="headers" :rows="rows"></Row>
    </tbody>
</template>
<script>
import Row from './Row.vue';
export default {
    props: {
        headers: {
            type: Array,
            required: true
        },
        rows: {
            type: Array,
            required: true
        },
    },
    components: {
        Row
    }
};
</script>