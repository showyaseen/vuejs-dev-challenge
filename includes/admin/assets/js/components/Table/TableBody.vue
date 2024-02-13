<template>
    <tbody>
        <Row v-for="(row, index) in rows" :headers="headers" :row="row"></Row>
    </tbody>
</template>
<script>
import Row from './Row.vue';
export default {
    name: "TableBody",
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