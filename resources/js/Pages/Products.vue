<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    products: Array,
});

console.log(props.products);
</script>

<template>
    <Head title="Produits" />

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold mb-6">Produits</h1>
        <div
            class="max-w-[1100px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-8"
        >
            <Link
                v-for="c in products"
                :key="c.id"
                :href="`/products/${c.id}`"
                class="group block bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/30 overflow-hidden"
            >
                <img
                    :src="`https://picsum.photos/seed/${c.id}/300/450`"
                    :alt="c.name"
                    class="h-[350px] w-full object-cover sm:h-[450px]"
                />

                <div class="mt-3 flex justify-between text-sm p-4">
                    <div>
                        <h3
                            class="text-gray-900 dark:text-gray-100 group-hover:underline group-hover:underline-offset-4"
                        >
                            {{ c.name }}
                        </h3>

                        <p class="mt-1.5 text-pretty text-xs text-gray-500 dark:text-gray-400">
                            {{ c.description }}
                        </p>
                    </div>

                    <p class="text-gray-900 dark:text-gray-100 font-medium">{{ c.price }}€</p>
                </div>
            </Link>
        </div>
    </div>
</template>