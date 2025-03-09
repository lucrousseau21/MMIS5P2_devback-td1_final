<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    order: {
        type: Object,
        required: true,
        default: () => ({}),
    },
});

console.log(props.order);
</script>

<template>
    <Head :title="`Détails de la commande ${order.id}`" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold mb-8">Commande #{{ order.id }}</h1>

        <div class="space-y-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/30 rounded-lg overflow-hidden">
                <div class="p-6">
                    <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Statut: {{ order.status }}
                    </p>
                    <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Total: {{ order.total }}€
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/30 rounded-lg overflow-hidden">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div v-for="item in order.items" :key="item.id" class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-24 h-24">
                                <img
                                    :src="`https://picsum.photos/seed/${item.product.id}/300/450`"
                                    :alt="item.product.name"
                                    class="w-full h-full object-cover rounded"
                                />
                            </div>
                            <div class="ml-6 flex-1">
                                <div class="flex items-center justify-between">
                                    <Link :href="`/products/${item.id}`">
                                        <h2
                                            class="text-lg font-medium text-gray-900 dark:text-gray-100"
                                        >
                                            {{
                                                item.product
                                                    ? item.product.name
                                                    : "Produit non disponible"
                                            }}
                                        </h2>
                                    </Link>
                                    <p
                                        class="text-lg font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        {{
                                            item.product
                                                ? item.product.price
                                                : "N/A"
                                        }}€
                                    </p>
                                </div>
                                <div
                                    class="mt-4 flex items-center justify-between"
                                >
                                    <div class="flex items-center">
                                        <label for="quantity" class="mr-2 dark:text-gray-300"
                                            >Quantité:</label
                                        >
                                        <input
                                            type="number"
                                            v-model="item.quantity"
                                            min="1"
                                            class="w-16 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm dark:shadow-gray-900/30 rounded-lg overflow-hidden p-6">
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Adresse de livraison
                </h2>
                <div class="border dark:border-indigo-700 rounded-lg p-4 space-y-2 border-indigo-500 bg-indigo-50 dark:bg-indigo-900/30">
                    <p class="font-medium">{{ order.address.address_line1 }}</p>
                    <p v-if="order.address.address_line2">
                        {{ order.address.address_line2 }}
                    </p>
                    <p>
                        {{ order.address.postal_code }} {{ order.address.city }}
                    </p>
                    <p>{{ order.address.country }}</p>
                </div>
            </div>
        </div>
    </div>
</template>