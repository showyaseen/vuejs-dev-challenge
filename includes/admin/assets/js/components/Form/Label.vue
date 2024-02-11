<template>
    <label :for="forInput" class="uppercase text-xs font-semibold text-gray-800 my-3 w-48">
    {{ title }}
    <slot></slot>
    </label>
</template>
<script>
export default {
    props: {
        forInput: String,
        title: String,
    }
};
</script>