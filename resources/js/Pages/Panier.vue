<script setup>
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
    panierItems: {
        type: Array,
        required: true,
        default: () => []
    },
    auth: {
        type: Object,
        required: true,
        default: () => ({})
    },
    panier: {
        type: Object,
        required: true,
        default: () => ({})
    }
});

console.log(props.panierItems);
console.log("panier", props.panier);
// const calculerTotal = () => {
//     return props.panier.reduce((total, item) => {
//         return total + (item.price * item.quantity);
//     }, 0);
// };

const addToPanier = () => {
    router.post("panier.add", props.product.id)(
        {
            quantity: quantity.value,
        },
        {
            onSuccess: () => {
                console.log("Produit ajouté au panier");
            }
        }
    )
}
</script>

<template>
    <Head title="Mon Panier" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Mon Panier</h1>

        <div v-if="panierItems.length === 0" class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">Votre panier est vide</p>
            <Link
                :href="route('products')"
                class="text-indigo-600 hover:text-indigo-500 font-medium"
            >
                Découvrir nos produits →
            </Link>
        </div>

        <div v-else class="space-y-8">
            <!-- Liste des produits -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200">
                    <div v-for="item in panierItems" :key="item.id" class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-24 h-24">
                                <img 
                                    src="https://picsum.photos/200/200" 
                                    :alt="item.product.name"
                                    class="w-full h-full object-cover rounded"
                                >
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ item.product.name }}
                                    </h2>
                                    <p class="text-lg font-medium text-gray-900">
                                        {{ item.product.price }}€
                                    </p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <label for="quantity" class="mr-2">Quantité:</label>
                                        <input 
                                            type="number" 
                                            :value="item.quantity"
                                            min="1"
                                            class="w-16 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                    </div>
                                    <button 
                                        class="text-red-600 hover:text-red-500"
                                        @click="router.delete(route('panierItems.remove', item.id))"
                                    >
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <!-- <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Résumé de la commande</h2>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <p>Sous-total</p>
                        <p>{{ calculerTotal() }}€</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Frais de livraison</p>
                        <p>Gratuit</p>
                    </div>
                    <div class="border-t pt-4 flex justify-between font-bold">
                        <p>Total</p>
                        <p>{{ calculerTotal() }}€</p>
                    </div>
                </div>
                <button 
                    class="mt-6 w-full bg-indigo-600 py-3 px-4 rounded-md text-white font-semibold hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    Procéder au paiement
                </button>
            </div> -->
        </div>
    </div>
</template>
