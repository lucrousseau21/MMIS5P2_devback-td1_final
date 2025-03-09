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
    <Head title="Catégories" />
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold mb-6">Catégories</h1>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            <Link
                v-for="category in categories"
                :key="category.id"
                :href="route('categories.show', category.slug)"
                class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg shadow-sm dark:shadow-gray-900/30 overflow-hidden transition duration-150 ease-in-out flex flex-col"
            >
                <img 
                    :src="`https://picsum.photos/seed/category-${category.id}0000/400/200`"
                    :alt="category.name"
                    class="w-full h-40 object-cover"
                />
                
                <div class="p-4 text-center font-semibold text-lg">
                    {{ category.name }}
                </div>
            </Link>
        </div>
    </div>
</template>