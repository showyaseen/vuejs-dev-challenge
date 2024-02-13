<template>
    <div class="m-5 mx-5 p-3 bg-red-200 text-red-800 rounded-md block">
        <slot></slot>
    </div>
</template>
<script>
export default {
    name: 'ErrorMessage',
};
</script>