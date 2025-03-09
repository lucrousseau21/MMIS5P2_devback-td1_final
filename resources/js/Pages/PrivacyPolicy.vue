<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

defineProps({
    policy: String,
});
</script>

<template>
    <Head title="Privacy Policy" />

    <div class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="pt-4 bg-gray-100 dark:bg-gray-900">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>

                <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-md dark:shadow-gray-900/30 overflow-hidden sm:rounded-lg prose dark:prose-invert" v-html="policy" />
            </div>
        </div>
    </div>
</template>

<style>
/* Ajout de styles pour la prose en mode sombre */
.dark .prose {
    color: #f3f4f6; /* text-gray-100 */
}

.dark .prose h1,
.dark .prose h2,
.dark .prose h3,
.dark .prose h4,
.dark .prose h5,
.dark .prose h6 {
    color: #f9fafb; /* text-gray-50 */
}

.dark .prose a {
    color: #93c5fd; /* text-blue-300 */
}

.dark .prose strong {
    color: #f9fafb; /* text-gray-50 */
}

.dark .prose ol > li::before {
    color: #9ca3af; /* text-gray-400 */
}

.dark .prose ul > li::before {
    background-color: #9ca3af; /* bg-gray-400 */
}

.dark .prose hr {
    border-color: #374151; /* border-gray-700 */
}

.dark .prose blockquote {
    color: #d1d5db; /* text-gray-300 */
    border-left-color: #4b5563; /* border-gray-600 */
}

.dark .prose code {
    color: #f9fafb; /* text-gray-50 */
    background-color: #374151; /* bg-gray-700 */
}

.dark .prose pre {
    color: #f9fafb; /* text-gray-50 */
    background-color: #1f2937; /* bg-gray-800 */
}

.dark .prose table {
    border-color: #4b5563; /* border-gray-600 */
}

.dark .prose thead {
    color: #f9fafb; /* text-gray-50 */
    border-bottom-color: #4b5563; /* border-gray-600 */
}

.dark .prose tbody tr {
    border-bottom-color: #374151; /* border-gray-700 */
}
</style>