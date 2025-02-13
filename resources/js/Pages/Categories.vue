<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    categories: {
        type: Array,
        required: true
    }
})

</script>

<template>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Catégories</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <a
                v-for="category in categories"
                :key="category.id"
                class="bg-white hover:bg-gray-50 text-gray-800 font-semibold py-3 px-6 border border-gray-300 rounded-lg shadow-sm transition duration-150 ease-in-out"
                href="#"
            >
                {{ category.name }}
            </a>
        </div>
    </div>
</template>
