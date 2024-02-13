<template>
    <a :href="'mailto:' + email" class="no-underline uppercase text-xs text-gray-700 font-semibold my-3 w-48">
        <slot>
            {{ email }}
        </slot>
    </a>
</template>
<script>
export default {
    name: 'Email',
    props: {
        email: String,
    }
};
</script>