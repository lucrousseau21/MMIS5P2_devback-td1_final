<script setup>
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    products: {
        type: String,
        required: true,
    },
});

console.log(props.producst);
</script>

<template>
    <h1>products</h1>

    <div v-for="c in products" :key="c.id" href="products">
        <!-- <p>{{ c.name }}</p>
        <p>{{ c.description }}</p> -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a v-for="c in products" :key="c.id" href="#" class="group block">
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

                    <p class="text-gray-900">{{ c.price }}</p>
                </div>
            </a>
        </div>
    </div>
</template>
