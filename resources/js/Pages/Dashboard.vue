<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Reservation from "@/types/models/Reservation";
import MyLink from "@/Components/MyLink.vue";

const goto = (route: string) => {
    router.visit(route);
};

defineProps<{
    reservation: Reservation | null
}>()
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center items-center gap-4 overflow-hidden mb-4">
                    <PrimaryButton @click="goto(route('reservations.create'))">Create reservation</PrimaryButton>
                    <SecondaryButton @click="goto(route('reservations.index'))">Show my reservations</SecondaryButton>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                    <h2 class="text-xl mb-2">Your next reservation</h2>
                    <div v-if="reservation === null">
                        <p class="">You do not have any reservation yet! <MyLink :href="route('reservations.create')">Create new reservation!</MyLink></p>
                    </div>
                    <div v-else class="flex items-center gap-4">
                        <div class="font-bold text-lg">{{ reservation.reservationDatetime }}</div>
                        <div>Tables reserved: <span class="font-bold">{{ reservation.numberOfTables }}</span></div>
                        <div>Special request: <span class="text-sm text-gray-500">{{ reservation.specialRequest }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
