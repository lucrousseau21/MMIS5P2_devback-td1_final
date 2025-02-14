<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    // products: {
    //     type: String,
    //     required: true,
    // },
    products: Array,
});

console.log(props.products);
</script>

<template>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-6">Produits</h1>
    <div
        class="max-w-[1100px] mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-8"
    >
        <Link
            v-for="c in products"
            :key="c.id"
            :href="`/products/${c.id}`"
            class="group block"
        >
            <img
                src="https://picsum.photos/200/300"
                alt=""
                class="h-[350px] w-full object-cover sm:h-[450px]"
            />

            <div class="mt-3 flex justify-between text-sm">
                <div>
                    <h3
                        class="text-gray-900 group-hover:underline group-hover:underline-offset-4"
                    >
                        {{ c.name }}
                    </h3>

                    <p class="mt-1.5 text-pretty text-xs text-gray-500">
                        {{ c.description }}
                    </p>
                </div>

                <p class="text-gray-900">{{ c.price }}€</p>
            </div>
        </Link>
    </div>
</div>
</template>
