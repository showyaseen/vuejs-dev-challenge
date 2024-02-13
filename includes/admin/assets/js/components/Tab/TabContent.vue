<template>
    <main>
        <div class="mx-auto max-w-7xl py-1 sm:px-6 lg:px-8">
            <div class="no-underline hover:border-orange-600 hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
                :id="'tabs-' + tabID" role="tabpanel" :data-te-tab-active="true"
                :aria-labelledby="'tabs-' + tabID">
                <slot>
                    <!-- {{ tabID }} Tab content here -->
                </slot>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: 'TabContent',
    props: { tabID: String },
};
</script>