<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    orders: {
        type: Array,
        required: true,
        default: () => [],
    },
});

console.log(props.orders);
</script>

<template>
    <Head title="Mes Commandes" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold mb-8">Mes Commandes</h1>

        <div v-if="orders.length === 0" class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">Vous n'avez pas encore passé de commande.</p>
            <Link
                :href="route('products')"
                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium"
            >
                Découvrir nos produits →
            </Link>
        </div>

        <div v-else class="space-y-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/30 rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div v-for="order in orders" :key="order.id" class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Commande #{{ order.id }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Statut: {{ order.status }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Total: {{ order.total }}€
                                </p>
                            </div>
                            <Link
                                :href="route('orders.show', { order: order.id })"
                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium"
                            >
                                Voir les détails →
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>