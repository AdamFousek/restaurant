<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueDatePicker, {DatePickerMarker} from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css"
import {computed, onMounted, ref, watch} from "vue";
import type Day from "@/types/models/Day";

const props = defineProps<{
    availableDays: Day[]
    minHour: number
    maxHour: number
}>()

const markers = ref<DatePickerMarker[]>([])
const allowedDays = ref<Date[]>([])
const availableHours = ref<number[]>([])
const availableMinutes = ref<string[]>([])

const date = ref<string>('')
const hour = ref<number>(props.minHour)
const minutes = ref<string>('00')
const numberOfTables = ref<number>(1)

const maxNumberOfTables = computed(() => {
    // handle this with config or something
    // -- still doesnt matter since every date availble in datepicker has available Tables
    // init doesnt metter, you have to select date anyway
    let max = 30;
    props.availableDays.forEach((day) => {
        if (day.dayFormatted === date.value) {
            max = day.availableTables
        }
    })

    return max;
})

onMounted(() => {
    props.availableDays.forEach((day) => {
        if (day.availableTables > 0) {
            allowedDays.value.push(new Date(day.day))
        } else {
            markers.value.push({
                date: new Date(day.day),
                type: 'line',
                tooltip: [
                    { text: 'No table available', color: 'red' },
                ],
            })
        }
    })

    for (let i = props.minHour; i <= props.maxHour; i++) {
        availableHours.value.push(i);
    }

    for (let i = 0; i < 60; i+=5) {
        if (i < 10) {
            availableMinutes.value.push('0' + i)
            continue
        }
        availableMinutes.value.push('' + i)
    }
})

const form = useForm({
    date: '',
    numberOfTables: 1,
    specialRequest: '',
})

const createReservations = () => {
    form.transform((data) => (
        {
            date: date.value + ' ' + hour.value + ':' + minutes.value,
            numberOfTables: numberOfTables.value,
            specialRequest: data.specialRequest,
        }
    )).post(route('reservations.store'));
}

const isDark = computed(() => {
    return document.documentElement.classList.contains("dark");
})

watch(numberOfTables, (newValue) => {
    if (newValue > maxNumberOfTables.value) {
        numberOfTables.value = maxNumberOfTables.value
    }
})

watch(date, (newValue) => {
    if (numberOfTables.value > maxNumberOfTables.value) {
        numberOfTables.value = maxNumberOfTables.value
    }
})
</script>

<template>
    <form class="flex flex-col gap-4" @submit.prevent="createReservations">
        <div class="self-center">
            <InputLabel for="date" value="Select date"/>

            <VueDatePicker
                    month-name-format="long"
                    :inline="true"
                    hide-offset-dates
                    auto-apply
                    :enable-time-picker="false"
                    v-model="date"
                    model-type="dd.MM.yyyy"
                    no-today
                    :allowed-dates="allowedDays"
                    :month-change-on-scroll="false"
                    :dark="isDark"
                    :markers="markers"
            />

            <InputError class="mt-2" :message="form.errors.date"/>
        </div>

        <div v-if="date" class="md:self-center">
            <InputLabel for="time" value="Time"/>

            <div class="flex justify-between gap-4">
                <select
                        id="hours"
                        v-model="hour"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                >
                    <option v-for="availableHour in availableHours" :value="availableHour">{{ availableHour }}</option>
                </select>
                <select
                        id="minutes"
                        v-model="minutes"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                >
                    <option v-for="availableMinute in availableMinutes" :value="availableMinute">{{ availableMinute }}</option>
                </select>
            </div>
        </div>

        <div v-if="date" class="md:self-center">
            <InputLabel for="numberOfTables" :value="'Number of tables (available ' + maxNumberOfTables + ')'"/>

            <input
                    id="numberOfTables"
                    v-model="numberOfTables"
                    type="number"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    required
                    :max="maxNumberOfTables"
            />

            <InputError class="mt-2" :message="form.errors.numberOfTables"/>
        </div>

        <div v-if="date">
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