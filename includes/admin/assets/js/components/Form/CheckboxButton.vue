<template>
	<div className="flex items-center justify-start">
		<button @click="$emit('update:modelValue', true)" :class="true === modelValue ?'bg-[#e27730] hover:bg-[#b85a1b] text-white' : 'bg-white hover:bg-orange-50 text-orange-500'" class="active:bg-orange-300/[.3]
			border
			border-orange-400
			border-solid
			cursor-pointer
			flex
			font-bold
			gap-4
			items-center
			px-4
			py-2
			my-5
			text-xs
			focus-visible:!outline
			focus-visible:!outline-1
			focus-visible:!outline-orange-500
			rounded-tl-3xl
			rounded-tr-none
			rounded-bl-3xl
			rounded-br-none
			ml-[-1px]
			min-w-[65px]">

			<div className="grid place-content-center">
				<slot name="left">Yes</slot>
			</div>

		</button>

		<button @click="$emit('update:modelValue', false)" :class="false === modelValue ?'bg-[#e27730] hover:bg-[#b85a1b] text-white' : 'bg-white hover:bg-orange-50 text-orange-500'" class="active:bg-orange-300/[.3]
				border
				border-orange-400
				border-solid
				cursor-pointer
				flex
				font-bold
				gap-4
				items-center
				px-4
				py-2
				text-xs
				focus-visible:!outline
				focus-visible:!outline-1
				focus-visible:!outline-orange-600
				border-radius:0px 25px 25px 0px
				rounded-tl-none
				rounded-tr-3xl
				rounded-bl-none
				rounded-br-3xl
				ml-[-1px]
				min-w-[65px]">

			<div className="grid place-content-center">
				<slot name="right">No</slot>
			</div>

		</button>
	</div>
</template>
<script>
export default {
	props: {
		modelValue: {
			type:Boolean,
			default: false
		},
	},
	name: 'CheckboxButton'
};
</script>