<template>
	<input type="email" :name="name" :id="id" :placeholder="placeholder" class="!border-gray-300
		!leading-5
		!m-0
		!mt-2
		!mb-0
		!px-3.5
		!py-2
		!rounded-lg
		!text-sm
		w-5/12
		focus-visible:!shadow-none
		focus-visible:!border
		focus-visible:!border-1
		focus-visible:!border-orange-500
		focus:shadow-none
		focus:border
		focus:border-1
		focus:border-orange-500
        hover:border
		hover:border-1
        hover:bg-gradient-to-r
		hover:!border-blue-500
		hover:!from-orange-500/0
		hover:!to-orange-500/5
		!placeholder:text-sm
		!placeholder:text-tundora" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
</template>

<script>
export default {
	props: {
		modelValue: String,
		id: {
			type: String,
			required: true
		},
		name: {
			type: String,
			required: true
		},
		placeholder: {
			type: String
		}
	}
};
</script>