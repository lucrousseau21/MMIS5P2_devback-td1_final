<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, reactive, computed } from "vue";

const props = defineProps({
    panierItems: {
        type: Array,
        required: true,
        default: () => [],
    },
    auth: {
        type: Object,
        required: true,
        default: () => ({}),
    },
    panier: {
        type: Object,
        required: true,
        default: () => ({}),
    },
    addresses: {
        type: Array,
        required: true,
        default: () => [],
    },
});

console.log(props.panierItems);
console.log("panier", props.panier);
console.log("addresses", props.addresses);

const originalQuantities = reactive({});
const modifiedQuantities = reactive({});

props.panierItems.forEach(item => {
    originalQuantities[item.id] = item.quantity;
    modifiedQuantities[item.id] = item.quantity;
});

const isQuantityModified = (itemId) => {
    return originalQuantities[itemId] !== modifiedQuantities[itemId];
};

const showAddAddressForm = ref(false);
const newAddress = ref({
    address_line1: "",
    address_line2: "",
    city: "",
    postal_code: "",
    country: "",
    is_default: false,
});

const selectedAddress = ref(
    props.addresses.find((addr) => addr.is_default) || null
);

const updateQuantity = (itemId, quantity) => {
    router.patch(
        route("panierItems.updateQuantity", itemId),
        { quantity: quantity },
        {
            onSuccess: () => {
                console.log("Quantité mise à jour avec succès");
                originalQuantities[itemId] = quantity;
            },
        }
    );
};

const removeItem = (itemId) => {
    router.delete(
        route("panierItems.remove", itemId),
        {},
        {
            onSuccess: () => {
                console.log("Produit supprimé du panier");
            },
        }
    );
};

const validatePanier = () => {
    if (!selectedAddress.value) {
        alert("Veuillez sélectionner une adresse de livraison.");
        return;
    }

    router.post(
        route("orders.store"),
        {
            address_id: selectedAddress.value.id,
        },
        {
            onSuccess: () => {
                console.log("Commande validée avec succès");
            },
        }
    );
};

const saveAddress = () => {
    router.post(route("addresses.store"), newAddress.value, {
        onSuccess: () => {
            console.log("Adresse ajoutée avec succès");
            showAddAddressForm.value = false;
            newAddress.value = {
                address_line1: "",
                address_line2: "",
                city: "",
                postal_code: "",
                country: "",
                is_default: false,
            };
        },
    });
};

const setDefaultAddress = (addressId) => {
    router.post(
        route("addresses.setDefault", addressId),
        {},
        {
            onSuccess: () => {
                console.log("Adresse définie comme adresse par défaut");
            },
        }
    );
};
</script>

<template>
    <Head title="Mon Panier" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold mb-8">Mon Panier</h1>

        <div v-if="panierItems.length === 0" class="text-center py-12">
            <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">Votre panier est vide</p>
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
                    <div v-for="item in panierItems" :key="item.id" class="p-6">
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
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <label for="quantity" class="mr-2 text-gray-700 dark:text-gray-300"
                                                >Quantité:</label
                                            >
                                            <input
                                                type="number"
                                                v-model="modifiedQuantities[item.id]"
                                                min="1"
                                                class="w-16 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                            />
                                        </div>
                                        <button
                                            :class="{
                                                'bg-indigo-600 hover:bg-indigo-700 text-white': isQuantityModified(item.id),
                                                'bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed': !isQuantityModified(item.id)
                                            }"
                                            class="py-1 px-3 rounded-md text-sm font-medium"
                                            :disabled="!isQuantityModified(item.id)"
                                            @click="updateQuantity(item.id, modifiedQuantities[item.id])"
                                        >
                                            Modifier
                                        </button>
                                    </div>
                                    <button
                                        class="text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300"
                                        @click="removeItem(item.id)"
                                    >
                                        Supprimer
                                    </button>
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

                <div v-if="addresses.length > 0" class="space-y-4 mb-6">
                    <div
                        v-for="address in addresses"
                        :key="address.id"
                        class="border dark:border-gray-700 rounded-lg p-4"
                        :class="{
                            'border-indigo-500 dark:border-indigo-400 bg-indigo-50 dark:bg-indigo-900/30':
                                selectedAddress &&
                                selectedAddress.id === address.id,
                        }"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-medium">
                                    {{ address.address_line1 }}
                                </p>
                                <p v-if="address.address_line2">
                                    {{ address.address_line2 }}
                                </p>
                                <p>
                                    {{ address.postal_code }} {{ address.city }}
                                </p>
                                <p>{{ address.country }}</p>
                                <div v-if="address.is_default" class="mt-2">
                                    <span
                                        class="px-2 py-1 bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 text-xs rounded-full"
                                        >Adresse par défaut</span
                                    >
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <button
                                    v-if="
                                        selectedAddress &&
                                        selectedAddress.id === address.id
                                    "
                                    class="text-gray-400 dark:text-gray-500 cursor-default"
                                    disabled
                                >
                                    Sélectionnée
                                </button>
                                <button
                                    v-else
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300"
                                    @click="selectedAddress = address"
                                >
                                    Sélectionner
                                </button>
                                <button
                                    v-if="!address.is_default"
                                    class="text-gray-600 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                    @click="setDefaultAddress(address.id)"
                                >
                                    Définir comme par défaut
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    v-if="!showAddAddressForm"
                    @click="showAddAddressForm = true"
                    class="flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                        />
                    </svg>
                    Ajouter une nouvelle adresse
                </button>

                <div
                    v-if="showAddAddressForm"
                    class="mt-4 border dark:border-gray-700 rounded-lg p-4"
                >
                    <div class="space-y-4">
                        <div>
                            <label
                                for="address_line1"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Adresse ligne 1 *</label
                            >
                            <input
                                type="text"
                                id="address_line1"
                                v-model="newAddress.address_line1"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            />
                        </div>
                        <div>
                            <label
                                for="address_line2"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Adresse ligne 2</label
                            >
                            <input
                                type="text"
                                id="address_line2"
                                v-model="newAddress.address_line2"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    for="city"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Ville *</label
                                >
                                <input
                                    type="text"
                                    id="city"
                                    v-model="newAddress.city"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                />
                            </div>
                            <div>
                                <label
                                    for="state"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >État *</label
                                >
                                <input
                                    type="text"
                                    id="state"
                                    v-model="newAddress.state"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                />
                            </div>
                            <div>
                                <label
                                    for="postal_code"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Code postal *</label
                                >
                                <input
                                    type="text"
                                    id="postal_code"
                                    v-model="newAddress.postal_code"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                                />
                            </div>
                        </div>
                        <div>
                            <label
                                for="country"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Pays *</label
                            >
                            <input
                                type="text"
                                id="country"
                                v-model="newAddress.country"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            />
                        </div>
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="is_default"
                                v-model="newAddress.is_default"
                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            />
                            <label
                                for="is_default"
                                class="ml-2 block text-sm text-gray-700 dark:text-gray-300"
                                >Définir comme adresse par défaut</label
                            >
                        </div>
                        <div class="flex space-x-3">
                            <button
                                @click="saveAddress"
                                class="bg-indigo-600 dark:bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                            >
                                Enregistrer
                            </button>
                            <button
                                @click="showAddAddressForm = false"
                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 py-2 px-4 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-gray-400"
                            >
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button
                        class="w-full bg-indigo-600 dark:bg-indigo-500 py-3 px-4 rounded-md text-white font-semibold hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400"
                        @click="validatePanier"
                        :disabled="!selectedAddress"
                    >
                        Valider le panier
                    </button>
                    <p
                        v-if="panierItems.length > 0 && !selectedAddress"
                        class="mt-2 text-sm text-red-500 dark:text-red-400 text-center"
                    >
                        Veuillez sélectionner une adresse de livraison pour
                        continuer
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>