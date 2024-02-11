<template>
    <button :disabled="disabled" :class="colors[color]" class="
        font-semibold
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
		rounded
		text-sm
		text-white
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
                green: 'bg-green-500 hover:bg-green-600',
                red: 'bg-red-600 hover:bg-red-700',
                blue: 'bg-blue-600 hover:bg-blue-700',
                orange: 'bg-[#e27730] hover:bg-[#b85a1b]',
            }
        };
    }
};
</script>