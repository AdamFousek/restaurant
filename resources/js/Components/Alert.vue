<script setup lang="ts">
defineProps<{
    alert: {
        type: string
        message: string
        header: string
    }
}>()
</script>

<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mt-4 p-4 rounded-lg"
             :class="{
                'bg-green-200 dark:bg-green-800 text-green-700 dark:text-green-300 border border-green-700 dark:border-green-300': alert.type === 'success',
                'bg-indigo-200 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 border border-indigo-700 dark:border-indigo-300': alert.type === 'info',
                'bg-amber-200 dark:bg-amber-800 text-amber-700 dark:text-amber-300 border border-amber-700 dark:border-amber-300': alert.type === 'warning',
                'bg-red-200 dark:bg-red-800 text-red-700 dark:text-red-300 border border-red-700 dark:border-red-300': alert.type === 'error',
             }">
            {{ alert.message }}
        </div>
    </div>
</template>

<style scoped>

</style>