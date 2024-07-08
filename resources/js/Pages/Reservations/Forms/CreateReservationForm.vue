<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css"
import type AvailableDays from "@/types/models/AvailableDays";
import {onMounted, ref} from "vue";
import type Marker from "@/types/models/Marker";

const props = defineProps<{
    availableDays: AvailableDays
    minHour: number
    maxHour: number
}>()

const markers = ref<Marker[]>([])
const allowedDays = ref<Date[]>([])
const availableHours = ref<number[]>([])
const availableMinutes = ref<number[]>([])

const hour = ref<number>(props.minHour)
const minutes = ref<number>(0)

onMounted(() => {
    markers.value = props.availableDays.markers;

    props.availableDays.days.forEach((day) => {
        if (day.isAvailable) {
            allowedDays.value.push(new Date(day.day))
        }
    })

    for (let i = props.minHour; i <= props.maxHour; i++) {
        availableHours.value.push(i);
    }

    for (let i = 0; i <= 60; i+=5) {
        availableMinutes.value.push(i)
    }
})

const form = useForm({
    date: '',
    time: '',
    numberOfTables: 1,
    specialRequest: '',
})

const createReservations = () => {
    form.transform((data) => (
        {
            date: data.date + ' ' + data.time,
            numberOfTables: data.numberOfTables,
            specialRequest: data.specialRequest,
        }
    )).post(route('reservations.store'));
}
</script>

<template>
    <form class="flex flex-col gap-4" @submit.prevent="createReservations">
        <div class="self-center">
            <InputLabel for="date" value="Date"/>

            <VueDatePicker
                    month-name-format="long"
                    :inline="true"
                    hide-offset-dates
                    auto-apply
                    :enable-time-picker="false"
                    v-model="form.date"
                    model-type="dd.MM.yyyy"
                    no-today
                    :allowed-dates="allowedDays"
                    :month-change-on-scroll="false"
            />

            <InputError class="mt-2" :message="form.errors.date"/>
        </div>

        <div class="md:self-center">
            <InputLabel for="time" value="Time"/>

            <div class="flex justify-between gap-4">
                <select
                        id="hours"
                        v-model="hour"
                        type="text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                >
                    <option v-for="availableHour in availableHours" :value="availableHour">{{ availableHour }}</option>
                </select>
                <select
                        id="minutes"
                        v-model="minutes"
                        type="text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                >
                    <option v-for="availableMinute in availableMinutes" :value="availableMinute">{{ availableMinute }}</option>
                </select>
            </div>

            <InputError class="mt-2" :message="form.errors.time"/>
        </div>

        <div class="md:self-center">
            <InputLabel for="numberOfTables" value="Number of tables"/>

            <input
                    id="numberOfTables"
                    v-model="form.numberOfTables"
                    type="number"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required
            />

            <InputError class="mt-2" :message="form.errors.numberOfTables"/>
        </div>

        <div>
            <InputLabel for="specialRequest" value="Special request"/>

            <textarea
                    id="specialRequest"
                    v-model="form.specialRequest"
                    type="text"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    cols="4"
                    rows="4"
            />

            <InputError class="mt-2" :message="form.errors.specialRequest"/>
        </div>

        <div class="flex items-center justify-end">
            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create reservation
            </PrimaryButton>
        </div>
    </form>
</template>

<style scoped>

</style>