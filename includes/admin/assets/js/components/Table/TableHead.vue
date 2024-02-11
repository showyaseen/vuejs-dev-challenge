<template>
    <thead class="text-xs text-gray-50 uppercase bg-[#e27730] hover:bg-[#b85a1b] dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">
                <span class="sr-only">#</span>
                #
            </th>
            <th v-for="header in headers" scope="col" class="px-6 py-3">
                {{ header }}
            </th>
        </tr>
    </thead>
</template>
<script>
export default {
    props: {
        headers: {
            type: Array,
            required: true
        },
    },
};
</script>