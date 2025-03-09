<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const page = usePage();
const auth = computed(() => page.props.auth || { user: null });
const isAuthenticated = computed(() => auth.value.user !== null);

// Mode sombre
const darkMode = ref(false);

// Initialiser le mode selon la préférence système ou stockée
onMounted(() => {
    // Vérifier si un thème est enregistré dans le localStorage
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme) {
        // Utiliser le thème enregistré
        darkMode.value = savedTheme === 'dark';
    } else {
        // Sinon, utiliser la préférence du système
        darkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    
    // Appliquer le thème
    applyTheme();
    
    // Écouter les changements de préférence système
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.getItem('theme')) { // Ne pas écraser la préférence utilisateur
            darkMode.value = e.matches;
            applyTheme();
        }
    });
});

// Observer les changements de mode et appliquer
watch(darkMode, () => {
    applyTheme();
    // Enregistrer la préférence
    localStorage.setItem('theme', darkMode.value ? 'dark' : 'light');
});

// Appliquer le thème au document
const applyTheme = () => {
    if (darkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

// Basculer manuellement le mode
const toggleDarkMode = () => {
    darkMode.value = !darkMode.value;
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div :class="{ 'dark': darkMode }">
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <ApplicationMark class="block h-9 w-auto dark:text-white" />
                                    <!-- <div class="block h-9 w-auto">
                                    <svg
                                        id="Calque_1"
                                        data-name="Calque 1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 500 500"
                                    >
                                        <g>
                                            <g>
                                                <path
                                                    class="cls-1"
                                                    d="M204.7,319.04h-22.83c-5.22,0-9.45-4.23-9.45-9.45v-142.06c0-3.24-.34-6.15-1-8.72-.67-2.57-2.2-4.67-4.57-6.29-2.39-1.62-6.25-2.43-11.58-2.43s-9.53.82-12,2.43c-2.48,1.62-4,3.71-4.57,6.29-.57,2.57-.86,5.48-.86,8.72v164.94c0,3.05.33,5.91,1,8.58.67,2.67,2.24,4.82,4.72,6.43,2.47,1.62,6.47,2.43,12,2.43h49.15c5.22,0,9.45-4.23,9.45-9.45v-11.97c0-5.22-4.23-9.45-9.45-9.45Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="M245.76,323.75c-1.34-2.18-3.19-3.52-5.57-4-2.39-.47-5-.71-7.86-.71h-18.75v30.87h19.04c2.86,0,5.43-.33,7.71-1,2.29-.67,4.1-2.09,5.43-4.29,1.33-2.18,2-5.66,2-10.43s-.67-8.24-2-10.44Z"
                                                />
                                            </g>
                                            <g>
                                                <path
                                                    class="cls-1"
                                                    d="M270.06,184.87v-34.87h-27.05c-5.34,0-9.25.82-11.72,2.43-2.47,1.62-4.05,3.71-4.71,6.29-.67,2.57-1,5.39-1,8.43v9.17c0,4.73,3.83,8.56,8.56,8.56h35.94Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="M361.93,330.09c-.57-2.66-2.19-5.91-4.86-9.72l-29.12-44.23c.13-.08.26-.15.39-.22,6.96-4.29,12.68-9.58,17.15-15.86,4.48-6.29,7.86-13.1,10.15-20.44,2.29-7.33,3.43-14.62,3.43-21.87,0-11.43-1.86-21.34-5.58-29.73-3.72-8.39-8.72-15.43-15-21.15-6.29-5.72-13.44-9.96-21.44-12.72-8-2.76-16.29-4.14-24.87-4.14h-22.75v34.87h22.18c6.86,0,12.72,1.29,17.58,3.86s8.57,6.29,11.15,11.15c2.57,4.86,3.85,10.72,3.85,17.58,0,5.72-.81,10.58-2.43,14.58-1.62,4-3.71,7.39-6.29,10.15-2.57,2.76-5.53,4.76-8.86,6-3.34,1.24-6.72,1.86-10.15,1.86h-39.76c-4.73,0-8.56,3.83-8.56,8.56v17.19c0,4.73,3.83,8.56,8.56,8.56h29.83c2.87,0,5.55,1.44,7.14,3.84l34.52,52.19c3.62,5.15,7.15,8.24,10.58,9.29,3.43,1.05,7.91-.43,13.44-4.43,4-2.86,6.76-5.43,8.29-7.72,1.52-2.29,2-4.76,1.43-7.44Z"
                                                />
                                            </g>
                                        </g>
                                        <rect
                                            class="cls-1"
                                            x="198.76"
                                            y="319.04"
                                            width="17.18"
                                            height="30.87"
                                        />
                                    </svg>
                                </div> -->
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('home')"
                                    :active="route().current('home')"
                                    class="dark:text-gray-300 dark:hover:text-white"
                                >
                                    Accueil
                                </NavLink>
                                <NavLink
                                    :href="route('categories')"
                                    :active="route().current('categories')"
                                    class="dark:text-gray-300 dark:hover:text-white"
                                >
                                    Catégories
                                </NavLink>
                                <NavLink
                                    :href="route('products')"
                                    :active="route().current('products')"
                                    class="dark:text-gray-300 dark:hover:text-white"
                                >
                                    Products
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Bouton de bascule du mode sombre -->
                            <button 
                                @click="toggleDarkMode" 
                                class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition duration-150 ease-in-out"
                                aria-label="Toggle dark mode"
                            >
                                <svg v-if="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                </svg>
                            </button>

                            <!-- Non connecté -->
                            <template v-if="!isAuthenticated">
                                <Link
                                    :href="route('login')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-white focus:outline-none transition"
                                >
                                    Se connecter
                                </Link>
                                <Link
                                    :href="route('register')"
                                    class="ml-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                >
                                    S'inscrire
                                </Link>
                            </template>

                            <!-- Connecté -->
                            <template v-else>
                                <!-- Ajout du bouton panier avant les autres éléments du header -->
                                <a
                                class="flex items-center gap-2 px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition duration-150 ease-in-out"
                                :href="route('panier')"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                                        />
                                    </svg>
                                </a>
                                <a
                                class="flex items-center gap-2 px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition duration-150 ease-in-out"
                                :href="route('orders.index')"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 3h18v4H3V3zm0 4v14h18V7H3zm3 4h12v2H6v-2zm0 4h12v2H6v-2z"
                                        />
                                    </svg>
                                </a>
                                <a
                                class="flex items-center gap-2 px-3 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition duration-150 ease-in-out"
                                :href="route('addresses.index')"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 11.25c1.518 0 2.75-1.232 2.75-2.75S13.518 5.75 12 5.75 9.25 6.982 9.25 8.5s1.232 2.75 2.75 2.75zM12 2.25c3.45 0 6.25 2.8 6.25 6.25 0 4.5-6.25 11.25-6.25 11.25S5.75 13 5.75 8.5C5.75 5.05 8.55 2.25 12 2.25z"
                                        />
                                    </svg>
                                </a>
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button
                                                v-if="
                                                    $page.props.jetstream
                                                        .managesProfilePhotos
                                                "
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-white focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150"
                                                    >
                                                <img
                                                    class="size-8 rounded-full object-cover"
                                                    :src="
                                                        $page.props.auth.user
                                                            .profile_photo_url
                                                    "
                                                    :alt="
                                                        $page.props.auth.user
                                                            .name
                                                    "
                                                />
                                            </button>

                                            <span
                                                v-else
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                                >
                                                    {{
                                                        $page.props.auth.user
                                                            .name
                                                    }}

                                                    <svg
                                                        class="ms-2 -me-0.5 size-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div
                                                class="block px-4 py-2 text-xs text-gray-400"
                                            >
                                                Gérer le compte
                                            </div>

                                            <DropdownLink
                                                :href="route('profile.show')"
                                            >
                                                Profil
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('panier')"
                                            >
                                                Mon panier
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('orders.index')"
                                            >
                                                Mes commandes 
                                            </DropdownLink>
                                            <DropdownLink
                                                :href="route('addresses.index')"
                                            >
                                                Mes adresses
                                            </DropdownLink>

                                            <div
                                                class="border-t border-gray-200"
                                            />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Déconnexion
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>
                            </template>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                            >
                                <svg
                                    class="size-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('home')"
                            :active="route().current('home')"
                        >
                            Accueil
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('categories')"
                            :active="route().current('categories')"
                        >
                            Catégories
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('products')"
                            :active="route().current('products')"
                        >
                            Products
                        </ResponsiveNavLink>
                    </div>

                    <!-- Non connecté (Mobile) -->
                    <template v-if="!isAuthenticated">
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="space-y-1">
                                <ResponsiveNavLink
                                    :href="route('login')"
                                    :active="route().current('login')"
                                >
                                    Se connecter
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('register')"
                                    :active="route().current('register')"
                                >
                                    S'inscrire
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </template>

                    <!-- Connecté (Mobile) -->
                    <template v-else>
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div
                                    v-if="
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                    class="shrink-0 me-3"
                                >
                                    <img
                                        class="size-10 rounded-full object-cover"
                                        :src="
                                            $page.props.auth.user
                                                .profile_photo_url
                                        "
                                        :alt="$page.props.auth.user.name"
                                    />
                                </div>

                                <div>
                                    <div
                                        class="font-medium text-base text-gray-800"
                                    >
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <div
                                        class="font-medium text-sm text-gray-500"
                                    >
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('profile.show')"
                                    :active="route().current('profile.show')"
                                >
                                    Profil
                                </ResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink as="button">
                                        Déconnexion
                                    </ResponsiveNavLink>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
    <Footer />
</template>
