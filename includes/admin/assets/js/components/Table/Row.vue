<template>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
        <td v-for="header in headers" class="m-0 py-0 text-gray-700 dark:text-white text-xs">
            <a v-if="'url' === header.toLowerCase()" :href="row.url"
                class="font-semibold text-[#e27730] dark:text-orange-500 hover:underline">{{ row.url }}
            </a>
            <h4 v-else>{{ row[header.toLowerCase()] || '' }}</h4>
        </td>
    </tr>
</template>
<script>
export default {
    name: "Row",
    props: {
        headers: {
            type: Array,
            required: true
        },
        row: {
            type: Object,
            required: true
        }
    }
};
</script>