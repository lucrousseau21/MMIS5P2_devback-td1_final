<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';


const props = defineProps({
    product: {
        type: String,
        required: true,
    },
});

console.log(props.products);
</script>

<template>
        <h1 class="text-3xl font-bold">page qui affiche qu'un produit</h1>
        
</template>
