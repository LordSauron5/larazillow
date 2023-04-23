<template>
    <span>
        {{ listing.street }} {{ listing.street_nr }} ,  {{ listing.city }} for R {{ listing.price }}
    </span>
</template>

<script setup>
    defineProps({
        listing: Object
    })
</script>