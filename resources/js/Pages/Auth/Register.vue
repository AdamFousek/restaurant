<script setup lang="ts">
import GuestLayout from '@/Layouts/AuthLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref, watch} from "vue";
import MyLink from "@/Components/MyLink.vue";

const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    phoneNumber: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {

    form.transform((data) => (
        {
            ...data,
            phoneNumber: data.phoneNumber.replace(/\s+/g, ''),
        }
    )).post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>

        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div class="flex flex-col md:flex-row md:justify-between gap-4">
                <div>
                    <InputLabel for="firstName" value="First Name"/>

                    <TextInput
                            id="firstName"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.firstName"
                            required
                            autofocus
                            autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.firstName"/>
                </div>
                <div>
                    <InputLabel for="lastName" value="Last Name"/>

                    <TextInput
                            id="lastName"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.lastName"
                            required
                            autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.lastName"/>
                </div>
            </div>


            <div>
                <InputLabel for="email" value="Email"/>

                <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div>
                <InputLabel for="phoneNumber" value="Phone Number"/>

                <TextInput
                        id="phoneNumber"
                        type="tel"
                        class="mt-1 block w-full"
                        v-model="form.phoneNumber"
                        required
                        autocomplete="username"
                        placeholder="+420123456789"
                />

                <InputError class="mt-2" :message="form.errors.phoneNumber"/>
            </div>

            <div>
                <InputLabel for="password" value="Password"/>

                <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <div>
                <InputLabel for="password_confirmation" value="Confirm Password"/>

                <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
            </div>

            <div class="flex items-center justify-end">
                <MyLink :href="route('login')">
                    Already registered?
                </MyLink>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
