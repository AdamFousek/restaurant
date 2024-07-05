<script setup lang="ts">
import DangerButton from "@/Components/DangerButton.vue";
import type Reservation from "@/types/models/Reservation";
import Modal from "@/Components/Modal.vue";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps<{
    reservation: Reservation
}>()

const confirmCancelReservation = ref(false);

const form = useForm({});

const cancelReservation = () => {
    form.delete(route('reservations.destroy', {reservation: props.reservation.id}));
};
</script>

<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
        <div class="flex justify-between">
            <h2 class="text-lg font-bold">{{ reservation.reservationDatetime }}</h2>
            <DangerButton @click="confirmCancelReservation = true">Cancel</DangerButton>
        </div>
        <div>Number of tables <span class="font-bold">{{ reservation.numberOfTables }}</span></div>
        <div v-if="reservation.specialRequest.length > 0">Special request: <span
                class="font-bold">{{ reservation.specialRequest }}</span></div>
    </div>
    <Modal :show="confirmCancelReservation" @close="confirmCancelReservation = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Are you sure you want to cancel your reservation?
            </h2>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="confirmCancelReservation = false">Cancel</SecondaryButton>

                <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="cancelReservation"
                >
                    Cancel Reservation
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>

<style scoped>

</style>