<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    auth: {
        type: Object,
        required: true
    }
});

console.log(props.products);
</script>

<template>
        <Head :title="product.name" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-8">
                <!-- Image du produit -->
                <div class="aspect-square overflow-hidden rounded-lg">
                    <img 
                        src="https://picsum.photos/800/800" 
                        :alt="product.name"
                        class="h-full w-full object-cover object-center"
                    >
                </div>

                <!-- Informations du produit -->
                <div class="mt-10 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                        {{ product.name }}
                    </h1>

                    <div class="mt-6">
                        <h2 class="sr-only">Description du produit</h2>
                        <p class="text-lg text-gray-700">
                            {{ product.description }}
                        </p>
                    </div>

                    <div class="mt-8">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ product.price }}€
                        </p>
                    </div>

                    <div class="mt-10">
                        <!-- Boutons pour utilisateur non connecté -->
                        <div v-if="!auth.user" class="space-y-4">
                            <Link
                                :href="route('login')"
                                class="w-full block text-center bg-indigo-600 py-3 px-4 rounded-md text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                Se connecter
                            </Link>
                            <Link
                                :href="route('register')"
                                class="w-full block text-center bg-white py-3 px-4 rounded-md text-indigo-600 font-semibold border border-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                                S'inscrire
                            </Link>
                        </div>

                        <!-- Bouton pour utilisateur connecté -->
                        <a
                            v-else
                            type="button"
                            class="w-full bg-indigo-600 py-3 px-4 rounded-md text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            Ajouter au panier
                        </a>
                    </div>

                    <!-- Retour à la liste des produits -->
                    <div class="mt-6">
                        <Link
                            :href="route('products')"
                            class="text-indigo-600 hover:text-indigo-500 font-medium"
                        >
                            ← Retour aux produits
                        </Link>
                    </div>
                </div>
            </div>
        </div>
</template>
