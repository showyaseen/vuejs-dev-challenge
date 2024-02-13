<template>
    <thead class="text-xs text-gray-50 uppercase bg-[#e27730] hover:bg-[#b85a1b] dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th v-for="header in headers" scope="col" class="px-0 lg:px-4 md:px-2 py-3">
                {{ header }}
            </th>
        </tr>
    </thead>
</template>
<script>
export default {
    name: "TableHead",
    props: {
        headers: {
            type: Array,
            required: true
        },
    },
};
</script>