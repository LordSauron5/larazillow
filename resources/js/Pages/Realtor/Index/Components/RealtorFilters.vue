<template>
    <form>
        <div class="mb-4 mt-4 flex flex-wrap gap-4">
            <div class="flex flex-nowrap items-center gap-2">
                <input 
                    id="deleted" 
                    v-model="filterForm.deleted"
                    type="checkbox" 
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <label for="deleted">Deleted</label>
            </div>

            <div>
                <select class="input-filter-l w-24" v-model="filterForm.by">
                    <option value="created_at">Added</option>
                    <option value="price">Price</option>
                </select>
                <select class="input-filter-r w-32" v-model="filterForm.order">
                    <option v-for="option in sortOptions" :key="option.value" :value="option.value">{{ option.label }}</option>
                </select>
            </div>
        </div>
    </form>
</template>

<script setup>

import { reactive, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { debounce } from 'lodash'

const sortLabels = {
    created_at: [
        {
            label: 'Latest',
            value: 'DESC'
        },
        {
            label: 'Oldest',
            value: 'ASC'
        }
    ],
    price: [
        {
            label: 'Highest',
            value: 'DESC'
        },
        {
            label: 'Lowest',
            value: 'ASC'
        }
    ]
}

const sortOptions = computed(() => sortLabels[filterForm.by])

const props = defineProps({
    filters: Object
});

const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'DESC',
})

watch(
    // debounce only processes the request sent after 1 second of no interruptions, process will use the final state 
    filterForm, debounce(() => router.get(
        route('realtor.listing.index'), 
        filterForm, 
        { preserveState: true, preseveScroll: true }
    ), 1000),
)
</script>