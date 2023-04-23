<template>
    <Link href="/listing">Listings</Link>&nbsp;
    <Link href="/listing/create">New Listing</Link>
    <div v-if="success" class="success">
        {{ success }}
    </div>
    <slot>Default</slot>
</template>

<script setup>
    import { computed } from 'vue'
    import { Link, usePage } from '@inertiajs/vue3'

    // page.props.value.flash.success
    const success = computed(()=> usePage().props.flash.success)
</script>

<style scoped>
    .success {
        background-color: green;
        color: white;
    }
</style>