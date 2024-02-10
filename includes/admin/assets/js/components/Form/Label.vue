<template>
    <label :for="forInput" class="uppercase text-xs text-gray-500 tracking-widest my-3 mr-5">
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