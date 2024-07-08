<script setup lang="ts">
import {Head, router} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CreateReservationForm from "@/Pages/Reservations/Forms/CreateReservationForm.vue";
import type Day from "@/types/models/Day";

defineProps<{
    availableDays: Day[]
    minHour: number
    maxHour: number
}>()

</script>

<template>
    <Head title="Create reservation" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create new reservation</h2>
                <SecondaryButton @click="router.visit(route('reservations.index'))">Back to my reservations</SecondaryButton>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <CreateReservationForm :availableDays="availableDays" :min-hour="minHour" :max-hour="maxHour" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>