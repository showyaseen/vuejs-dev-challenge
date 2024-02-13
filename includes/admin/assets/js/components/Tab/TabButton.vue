<template>
    <router-link :to="{ path: data.path }" :class="{ 'border-b-orange-600': data.is_active }"
        class="p-4 no-underline border-0 border-transparent focus:border-transparent focus:ring-0 border-b-4 hover:border-b-gray-500 focus:border-b-orange-600 border-solid block mt-0 inline-block text-gray-500 hover:text-gray-500 focus:text-gray-600 mx-4">
        {{ data.title }}
    </router-link>
</template>
<script>

export default {
    name: 'TabButton',
    props: {
        data: {
            id: String,
            title: String,
            path: String,
            is_active: Boolean
        }
    },
};
</script>