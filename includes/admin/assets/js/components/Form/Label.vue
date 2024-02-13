<template>
    <label :for="forInput" class="text-sm font-semibold text-gray-800 my-3 w-48">
        {{ title }}
        <slot></slot>
    </label>
</template>
<script>
export default {
    name: 'Label',
    props: {
        forInput: String,
        title: String,
    }
};
</script>