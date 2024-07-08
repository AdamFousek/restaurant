<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import type Menu from '@/types/models/Menu';
import {ref} from 'vue';

const props = defineProps<{
    menu: Menu[]
}>()

const activeMenu = ref<Menu>(props.menu[0])
</script>

<template>
    <Head title="Menu"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Menu</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="overflow-scroll md:overflow-hidden p-4 flex md:justify-center">
                    <div class="flex gap-2">
                        <div v-for="day in menu" :key="day.dayName"
                             @click="activeMenu = day"
                             class="flex flex-col items-center p-2 rounded-lg shadow-md cursor-pointer"
                             :class="{
                                'bg-indigo-100 dark:bg-indigo-900': activeMenu.date === day.date,
                                'bg-white dark:bg-gray-700': activeMenu.date !== day.date
                             }"
                        >
                            <span class="font-bold dark:text-white">{{ day.dayName }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-300">{{ day.date }}</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 dark:text-white">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-200">Menu for {{ activeMenu.dayName }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Here you can see the menu for the selected day.</p>
                        <h4 class="font-bold mt-4">Soup:</h4>
                        <div class="flex justify-between">
                            <div>{{ activeMenu.menu.soup.name }} <span class="text-sm text-gray-500 dark:text-gray-400">{{ activeMenu.menu.soup.content}}</span></div>
                            <div class="font-bold">{{ activeMenu.menu.soup.price }}</div>
                        </div>

                        <h4 class="font-bold mt-4">Main:</h4>
                        <div class="flex justify-between">
                            <div>{{ activeMenu.menu.main.name }} <span class="text-sm text-gray-500 dark:text-gray-400">{{ activeMenu.menu.main.content}}</span></div>
                            <div class="font-bold">{{ activeMenu.menu.main.price }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>