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

<template class="bg-gray-50 max-w-[1100px]">
    <AppLayout>
        <!-- <h1 class="text-3xl font-bold">home</h1> -->
        <section class="bg-gray-50 h-[75vh]">
            <div
                class="mx-auto max-w-screen-xl px-4 py-32 lg:flex lg:h-screen lg:items-center"
            >
                <div class="mx-auto max-w-xl text-center">
                    <h1 class="text-3xl font-extrabold sm:text-5xl">
                        Votre nouvelle boutique.
                        <strong class="font-extrabold text-red-600 sm:block">
                            Luc Shop.
                        </strong>
                    </h1>

                    <p class="mt-4 sm:text-xl/relaxed">
                        Luc Shop vous propose une large gamme de produits de
                        qualité à des prix compétitifs.
                    </p>

                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a
                            class="block w-full rounded-md bg-red-600 px-12 py-3 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:ring-3 focus:outline-hidden sm:w-auto"
                            href="products"
                        >
                            Produits
                        </a>

                        <a
                            class="block w-full rounded-md px-12 py-3 text-sm font-medium text-red-600 shadow-sm hover:text-red-700 focus:ring-3 focus:outline-hidden sm:w-auto"
                            href="categories"
                        >
                            Catégories
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- div pour afficher toutes les catégories avec des boutons -->
        <div class="flex flex-row gap-4 p-8 overflow-auto">
            <a
                href="categories"
                v-for="c in categories"
                :key="c.id"
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700"
            >
                {{ c.name }}
            </a>
        </div>
    </AppLayout>
</template>
