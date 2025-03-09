<script setup>
import { defineProps } from 'vue';
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    category: {
        type: Object,
        required: true
    },
    products: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <Head :title="category.name" />
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
        <div class="mb-6">
            <img 
                :src="`https://picsum.photos/seed/category-${category.id}0000/1200/300`"
                :alt="category.name"
                class="w-full h-[200px] object-cover rounded-lg shadow-md dark:shadow-gray-900/30"
            />
        </div>
        
        <h1 class="text-3xl font-bold mb-6">{{ category.name }}</h1>

        <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">{{ category.description }}</p>
        
        <div class="max-w-[1100px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-8">
            <Link
                v-for="product in products"
                :key="product.id"
                :href="`/products/${product.id}`"
                class="group block bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-sm dark:shadow-gray-900/30 hover:shadow-md dark:hover:shadow-gray-900/50 transition-shadow duration-200"
            >
                <img
                    :src="`https://picsum.photos/seed/${product.id}/300/450`"
                    :alt="product.name"
                    class="h-[350px] w-full object-cover sm:h-[450px]"
                />

                <div class="mt-3 flex justify-between text-sm p-4">
                    <div>
                        <h3
                            class="text-gray-900 dark:text-gray-100 group-hover:underline group-hover:underline-offset-4"
                        >
                            {{ product.name }}
                        </h3>

                        <p class="mt-1.5 text-pretty text-xs text-gray-500 dark:text-gray-400">
                            {{ product.description }}
                        </p>
                    </div>

                    <p class="text-gray-900 dark:text-gray-100 font-medium">{{ product.price }}€</p>
                </div>
            </Link>
        </div>
    </div>
</template>