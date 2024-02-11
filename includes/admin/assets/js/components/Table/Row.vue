<template>
    <tr v-for="(row, index) in rows"
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
        <td class="py-0 text-gray-900 dark:text-white whitespace-nowrap">
            {{ index + 1 }}
        </td>
        <td v-for="header in headers" class=" py-0 text-gray-700 dark:text-white text-xs">
            <a v-if="'url' === header.toLowerCase()" :href="row.url"
                class="font-bold text-[#e27730] dark:text-orange-500 hover:underline">{{ row.url }}
            </a>
            <h4 v-else>{{ row[header.toLowerCase()] || '' }}</h4>
        </td>
    </tr>
</template>
<script>
export default {
    props: {
        headers: {
            type: Array,
            required: true
        },
        rows: {
            type: Array,
            required: true
        }
    }
};
</script>