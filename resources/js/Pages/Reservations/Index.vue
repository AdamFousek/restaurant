<script setup lang="ts">
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Paginate from "@/Components/Paginate.vue";
import type Reservation from "@/types/models/Reservation";
import ReservationItem from "@/Pages/Reservations/partials/ReservationItem.vue";

defineProps<{
    reservations: Reservation[]
    paginate: {
        total: number
        per_page: number
        current_page: number
        links: string[]
    }
}>()
</script>

<template>
    <Head title="My reservations" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My reservations</h2>
                <PrimaryButton @click="router.visit(route('reservations.create'))">Create new reservation</PrimaryButton>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <ReservationItem v-for="reservation in reservations" :key="reservation.id" :reservation="reservation" />

                <Paginate v-if="reservations.length > 0" :pages="paginate.links" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>