<script setup lang="ts">
import {Link} from "@inertiajs/vue3";

defineProps<{
    href: string;
}>();
</script>

<template>
    <Link :href="href" class="underline text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        <slot />
    </Link>
</template>

<style scoped>

</style>