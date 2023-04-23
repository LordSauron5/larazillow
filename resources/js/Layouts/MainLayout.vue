<template>
    <Link href="/">Main Page</Link>&nbsp;
    <Link href="/hello">Show Page</Link>
    <!-- <div>The Page with timer: {{ timer }}</div> -->
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

    // const timer = ref(0)
    // setInterval(() => {
    //     timer.value++
    // }, 1000);
</script>

<style scoped>
    .success {
        background-color: green;
        color: white;
    }
</style>