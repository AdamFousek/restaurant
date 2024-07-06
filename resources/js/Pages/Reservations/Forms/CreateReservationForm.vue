<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
        <div class="flex flex-col md:flex-row md:justify-between gap-4">
            <div>
                <InputLabel for="date" value="Date"/>

                <input
                        id="date"
                        v-model="form.date"
                        type="date"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                        autofocus
                />

                <InputError class="mt-2" :message="form.errors.date"/>
            </div>
            <div>
                <InputLabel for="time" value="Time"/>

                <input
                        id="time"
                        v-model="form.time"
                        type="text"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        required
                        autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.time"/>
            </div>
        </div>


        <div>
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