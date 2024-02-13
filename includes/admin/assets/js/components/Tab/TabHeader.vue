<template>
    <div>
        <div class="flex items-center flex-shrink-0 text-gray-700 ml-1 lg:ml-6 md:ml-6 mb-6 p-2">
            <CommandLineIcon></CommandLineIcon>
            <span class="text-xl font-semibold tracking-tight">{{ title }}</span>
        </div>
        <span class="relative -top-10 left-[57px] -lg:top-4 lg:left-20 -md:top-14 md:left-20 uppercase font-semibold text-xs lg:tracking-widest text-gray-500 my-3"> {{ subTitle }}</span>

        <nav class="flex items-center justify-between flex-wrap bg-white shadow-md">
            <div class="w-full block flex-grow flex items-center w-auto">
                <div class="text-sm flex-grow h-14">
                    <slot></slot>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
import CommandLineIcon from '../Icons/CommandLineIcon.vue';
export default {
    name: "TabHeader",
    props: {
        title: String,
        subTitle: String,
    },
    components: {
        CommandLineIcon
    }
};
</script>
