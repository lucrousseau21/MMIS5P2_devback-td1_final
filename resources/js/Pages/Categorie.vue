<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: String,
        required: true,
    },
});

console.log(props.categories)
</script>

<template>
    <h1>luc rousseau</h1>

    <a v-for="c in categories" :key="c.id" href="categories">
        <p class="hover:font-bold">{{ c.name }}</p>
    </a>
</template>
