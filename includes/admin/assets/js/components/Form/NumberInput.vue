<template>
	<input type="number" :name="name" :id="id" :placeholder="placeholder" :min="min" :max="max"
    class="!border-gray-300
		!leading-5
		!m-0
        !my-3
		!px-3.5
		!py-2
		!rounded-lg
		!text-sm
        text-center
		w-24
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
	name: 'NumberInput',
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
		},
		min: {
			type: Number,
            default: 0
		},
		max: {
			type: Number,
            default: 5
		},
		value: {
			type: Number,
			required: true
		}
	}
};
</script>