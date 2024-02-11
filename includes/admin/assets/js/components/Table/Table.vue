<template>
        <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400 relative shadow-md">
            <TableHead :headers="headers"></TableHead>
            <TableBody :headers="headers" :rows="rows"></TableBody>
        </table>
</template>
<script>
import TableHead from './TableHead.vue';
import TableBody from './TableBody.vue';
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
        TableHead,
        TableBody
    }
};
</script>