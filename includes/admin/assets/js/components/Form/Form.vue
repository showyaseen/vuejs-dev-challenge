<template>
    <form @submit.prevent="submitForm" class="p-4">
        <slot></slot>
    </form>
</template>
<script>
export default {
    name: 'Form',
};
</script>