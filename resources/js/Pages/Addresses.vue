<script setup>
import { ref } from "vue";
import { router, Head } from "@inertiajs/vue3";

const props = defineProps({
    addresses: {
        type: Array,
        required: true,
    },
});

const newAddress = ref({
    address_line1: "",
    address_line2: "",
    city: "",
    state: "",
    postal_code: "",
    country: "",
    is_default: false,
});

const editingAddressId = ref(null);

const saveAddress = () => {
    if (editingAddressId.value) {
        router.put(
            route("addresses.update", editingAddressId.value),
            newAddress.value,
            {
                onSuccess: () => {
                    console.log("Adresse mise à jour avec succès");
                    resetForm();
                },
            }
        );
    } else {
        router.post(route("addresses.store"), newAddress.value, {
            onSuccess: () => {
                console.log("Adresse ajoutée avec succès");
                resetForm();
            },
        });
    }
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

const editAddress = (address) => {
    newAddress.value = { ...address };
    editingAddressId.value = address.id;
};

const deleteAddress = (addressId) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette adresse ?")) {
        router.delete(route("addresses.destroy", addressId), {
            onSuccess: () => {
                console.log("Adresse supprimée avec succès");
            },
        });
    }
};

const resetForm = () => {
    newAddress.value = {
        address_line1: "",
        address_line2: "",
        city: "",
        state: "",
        postal_code: "",
        country: "",
        is_default: false,
    };
    editingAddressId.value = null;
};
</script>

<template>
    <Head title="Mes adresses" />
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold mb-8">Mes Adresses</h1>

        <div class="space-y-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-4">Adresses</h2>
                <div v-if="addresses.length > 0" class="space-y-4">
                    <div
                        v-for="address in addresses"
                        :key="address.id"
                        class="border dark:border-gray-700 rounded-lg p-4"
                        :class="{
                            'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/30':
                                address.is_default,
                        }"
                    >
                        <div v-if="editingAddressId === address.id">
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
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                </div>
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        id="is_default"
                                        v-model="newAddress.is_default"
                                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500"
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
                                        class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                    >
                                        Enregistrer
                                    </button>
                                    <button
                                        @click="resetForm"
                                        class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800"
                                    >
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-medium">
                                        {{ address.address_line1 }}
                                    </p>
                                    <p v-if="address.address_line2">
                                        {{ address.address_line2 }}
                                    </p>
                                    <p>
                                        {{ address.postal_code }}
                                        {{ address.city }}
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
                                        v-if="!address.is_default"
                                        class="text-gray-600 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                        @click="setDefaultAddress(address.id)"
                                    >
                                        Définir comme par défaut
                                    </button>
                                    <button
                                        class="text-gray-600 dark:text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                        @click="editAddress(address)"
                                    >
                                        Modifier
                                    </button>
                                    <button
                                        v-if="!address.is_default"
                                        class="text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300"
                                        @click="deleteAddress(address.id)"
                                    >
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-gray-500 dark:text-gray-400">Aucune adresse trouvée.</p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden p-6">
                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Ajouter une nouvelle adresse
                </h2>
                <div class="space-y-4">
                    <div>
                        <label
                            for="address_line1_new"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Adresse ligne 1 *</label
                        >
                        <input
                            type="text"
                            id="address_line1_new"
                            v-model="newAddress.address_line1"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                    <div>
                        <label
                            for="address_line2_new"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Adresse ligne 2</label
                        >
                        <input
                            type="text"
                            id="address_line2_new"
                            v-model="newAddress.address_line2"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                for="city_new"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Ville *</label
                            >
                            <input
                                type="text"
                                id="city_new"
                                v-model="newAddress.city"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>
                        <div>
                            <label
                                for="state_new"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >État *</label
                            >
                            <input
                                type="text"
                                id="state_new"
                                v-model="newAddress.state"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>
                        <div>
                            <label
                                for="postal_code_new"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Code postal *</label
                            >
                            <input
                                type="text"
                                id="postal_code_new"
                                v-model="newAddress.postal_code"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                    <div>
                        <label
                            for="country_new"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Pays *</label
                        >
                        <input
                            type="text"
                            id="country_new"
                            v-model="newAddress.country"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        />
                    </div>
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="is_default_new"
                            v-model="newAddress.is_default"
                            class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500"
                        />
                        <label
                            for="is_default_new"
                            class="ml-2 block text-sm text-gray-700 dark:text-gray-300"
                            >Définir comme adresse par défaut</label
                        >
                    </div>
                    <div class="flex space-x-3">
                        <button
                            @click="saveAddress"
                            class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>