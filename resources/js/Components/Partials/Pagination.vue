<script setup>
    import { Link } from "@inertiajs/vue3"
    const props = defineProps({
        links: Array
    })
</script>

<template>
    <div v-if="links.length > 0">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label" />
                <Link v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-indigo-400 focus:border-indigo-500 focus:text-indigo-500 dark:text-white"
                    :class="{ 'bg-blue-700 text-white': link.active }" :href="link.url" v-html="link.label" />
            </template>
        </div>
    </div>
</template>
