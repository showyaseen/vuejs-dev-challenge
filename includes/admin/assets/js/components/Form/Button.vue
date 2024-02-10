<template>
    <button :disabled="disabled" :class="colors[color]" class="active:from-red-500
		active:to-purple-500
		disabled:opacity-50
		disabled:!from-emperor-600
		disabled:!to-black
		disabled:hover:!from-emperor-600
		disabled:hover:!to-black
		bg-gradient-135
		border-none
		cursor-pointer
		flex
		gap-1
		items-center
		px-4
		py-2
        my-5
		rounded-full
		text-sm
		text-white
		focus:from-red-500/90
		focus:to-purple-500/90
		hover:from-red-500/90
		hover:to-purple-500/90
		focus-visible:!outline
		focus-visible:!outline-1
		focus-visible:!outline-purple">
        <slot></slot>
    </button>
</template>
<script>
export default {
    name: 'Button',
    props: {
        color: {
            type: String,
            default: 'green'
        },
        disabled: {
            type: Boolean,
            default: false
        },
        title: String,
    },
    data() {
        return {
            colors: {
                green: 'bg-green-500',
                red: 'bg-red-600',
                blue: 'bg-blue-600',
            }
        };
    }
};
</script>