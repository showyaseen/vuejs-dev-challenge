<template>
    <div>
        <div class="flex items-center flex-shrink-0 text-gray-700 m-4 p-4">
            <span class="font-semibold text-xl tracking-tight">{{ title }}</span>
        </div>
        <nav class="flex items-center justify-between flex-wrap bg-white shadow-md">
            <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                <div class="text-sm lg:flex-grow h-14">
                    <slot></slot>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "TabHeader",
    props: {
        title: String,
    }
};
</script>
