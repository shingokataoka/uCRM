<script setup>
import {Link} from '@inertiajs/inertia-vue3';

defineProps({
    links: Array,
});


</script>

<style>
    nav ul > li:nth-child(1) * {
        border-radius: 6px 0 0 6px;
    }
    nav ul > li:nth-last-child(1) * {
        border-radius: 0 8px 8px 0;
    }
</style>

<template>

<nav aria-label="Page navigation">
  <ul class="inline-flex -space-x-px">
    <li v-for="(link, index) in links" :key="link.index">
        <span v-if="link.active" v-html="link.label" aria-current="page" class=" py-2 px-3 text-blue-600 bg-blue-50 border border-gray-300 hover:bg-blue-100 hover:text-blue-700 "></span>

        <span v-else-if="link.url === null" :href="link.url" v-html="link.label" class="py-2 px-3 leading-tight text-gray-400 bg-white border border-gray-300"></span>

        <Link v-else :href="link.url" v-html="link.label" class="py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 "></Link>
    </li>
  </ul>
</nav>

</template>
