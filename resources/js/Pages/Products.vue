<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: String,
        required: true,
    },
});

console.log(props.producst)
</script>

<template>
    <h1>products</h1>

    <a v-for="c in products" :key="c.id" href="products">
        <p>{{ c.name }} </p>
        <p>{{ c.description }}</p>
    </a>
</template>
