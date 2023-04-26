<template>
    
    <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 w-full">
        <div class="container mx-auto">
            <nav class="p-4 flex items-center justify-between">
                <div class="text-lg font-medium">
                    <Link :href="route('listing.index')">Listings</Link>&nbsp;
                </div>
                <div class="text-cl text-indigo-600 dark:text-indigo-300 font-bold text-center">
                    <Link :href="route('listing.index')">LaraZillow</Link>&nbsp;
                </div>
                <div>
                    <Link :href="route('listing.create')" class="btn-primary">+ New Listing</Link>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4">
        <div v-if="success" class="mb-4 border rounded-md shadow-sm border-green dark:border-green-800 bg-green50 dark:bg-green-900 p-2">
            {{ success }}
        </div>
        <slot>Default</slot>
    </main>
</template>

<script setup>
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    const success = computed(()=> usePage().props.flash.success)
</script>