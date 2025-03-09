<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    categories: {
        type: String,
        required: true,
    },
});

// console.log(props.categories)
</script>

<template>
    <Head title="Home" />
    <!-- Section d'accueil principale -->
    <section class="bg-gray-50 dark:bg-gray-900 h-[75vh]">
        <div
            class="mx-auto max-w-screen-xl px-4 py-32 lg:flex lg:h-screen lg:items-center"
        >
            <div class="mx-auto max-w-xl text-center">
                <h1 class="text-3xl font-extrabold sm:text-5xl text-gray-900 dark:text-gray-100">
                    Votre nouvelle boutique.
                    <strong class="font-extrabold text-red-600 dark:text-red-400 sm:block">
                        Luc Shop.
                    </strong>
                </h1>

                <p class="mt-4 sm:text-xl/relaxed text-gray-700 dark:text-gray-300">
                    Luc Shop vous propose une large gamme de produits de
                    qualité à des prix compétitifs.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a
                        class="block w-full rounded-md bg-red-600 px-12 py-3 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:ring-3 focus:ring-red-500 dark:focus:ring-red-400 focus:outline-hidden sm:w-auto"
                        href="products"
                    >
                        Produits
                    </a>

                    <a
                        class="block w-full rounded-md px-12 py-3 text-sm font-medium text-red-600 dark:text-red-400 shadow-sm hover:text-red-700 dark:hover:text-red-300 border border-red-600 dark:border-red-400 focus:ring-3 focus:ring-red-500 dark:focus:ring-red-400 focus:outline-hidden sm:w-auto"
                        href="categories"
                    >
                        Catégories
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section des catégories -->
    <div class="bg-white dark:bg-gray-800 flex flex-row gap-4 p-8 overflow-auto">
        <a
            v-for="c in categories"
            :href="'/categories/' + c.slug"
            :key="c.id"
            class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-2 rounded-md transition-colors duration-200"
        >
            {{ c.name }}
        </a>
    </div>
</template>