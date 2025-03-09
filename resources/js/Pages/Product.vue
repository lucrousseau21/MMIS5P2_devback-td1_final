<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from 'vue';

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

const quantity = ref(1);
const showPopup = ref(false);

const addToPanier = () => {
    router.post(
        route('panier.add', props.product.id), {
        quantity: quantity.value,
    },
    {
        onSuccess: () => {
            console.log("Produit ajouté au panier");
            showPopup.value = true;
        }
    });
}

const incrementQuantity = () => {
    if (quantity.value < props.product.stock) {
        quantity.value++;
    }
}

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
}

const closePopup = () => {
    showPopup.value = false;
}

const goToCart = () => {
    router.visit(route('panier'));
}
</script>

<template>
    <Head :title="product.name" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-900 dark:text-gray-100">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8">
            <div class="aspect-square overflow-hidden rounded-lg">
                <img 
                    :src="`https://picsum.photos/seed/${product.id}/300/450`"
                    :alt="product.name"
                    class="h-full w-full object-cover object-center"
                >
            </div>

            <div class="mt-10 lg:mt-0">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                    {{ product.name }}
                </h1>

                <div class="mt-6">
                    <h2 class="sr-only">Description du produit</h2>
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        {{ product.description }}
                    </p>
                </div>

                <div class="mt-8">
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ product.price }}€
                    </p>
                </div>

                <div class="mt-10">
                    <div v-if="!auth.user" class="space-y-4">
                        <Link
                            :href="route('login')"
                            class="w-full block text-center bg-indigo-600 py-3 px-4 rounded-md text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800"
                        >
                            Se connecter
                        </Link>
                        <Link
                            :href="route('register')"
                            class="w-full block text-center bg-white dark:bg-gray-700 py-3 px-4 rounded-md text-indigo-600 dark:text-indigo-400 font-semibold border border-indigo-600 dark:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800"
                        >
                            S'inscrire
                        </Link>
                    </div>

                    <div v-else class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Quantité
                            </label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md">
                                <button 
                                    type="button" 
                                    @click="decrementQuantity"
                                    class="px-3 py-1 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
                                >
                                    -
                                </button>
                                <input 
                                    type="number" 
                                    id="quantity" 
                                    v-model="quantity" 
                                    min="1"
                                    :max="product.stock"
                                    class="w-16 py-1 px-2 border-none focus:ring-0 text-center bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                                />
                                <button 
                                    type="button" 
                                    @click="incrementQuantity"
                                    class="px-3 py-1 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
                                >
                                    +
                                </button>
                            </div>
                            <!-- <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ product.stock }} disponible(s)
                            </span> -->
                        </div>
                        
                        <button 
                            @click="addToPanier"
                            class="w-full bg-indigo-600 py-3 px-4 rounded-md text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800"
                        >
                            Ajouter au panier
                        </button>
                    </div>
                </div>

                <div class="mt-6">
                    <Link
                        :href="route('products')"
                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium"
                    >
                        ← Retour aux produits
                    </Link>
                </div>
            </div>
        </div>
        
        <div v-if="showPopup" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-black opacity-50" @click="closePopup"></div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg dark:shadow-gray-900/50 z-10 max-w-md w-full text-gray-900 dark:text-gray-100">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 dark:text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Produit ajouté au panier</h3>
                </div>
                
                <div class="flex items-center space-x-4 mb-4">
                    <img 
                        :src="`https://picsum.photos/seed/${product.id}/100/100`"
                        :alt="product.name"
                        class="h-16 w-16 object-cover rounded"
                    >
                    <div>
                        <p class="font-medium">{{ product.name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Quantité: {{ quantity }}</p>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                    <button
                        @click="closePopup"
                        class="w-full sm:w-1/2 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800"
                    >
                        Continuer mes achats
                    </button>
                    <button
                        @click="goToCart"
                        class="w-full sm:w-1/2 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:focus:ring-offset-gray-800"
                    >
                        Voir mon panier
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>