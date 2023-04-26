<template>
    <form @submit.prevent="create">
      <div class="grid grid-cols-6 gap-4">
        <div class="col-span-2">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Beds</label>
          <input type="text"  v-model.number="form.beds" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.beds">
                {{ form.errors.beds }}
            </div>
        </div>
  
        <div class="col-span-2">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Baths</label>
          <input type="text" v-model.number="form.baths" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.baths">
                {{ form.errors.baths }}
            </div>
        </div>
  
        <div class="col-span-2">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Area</label>
          <input type="text" v-model.number="form.area" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.area">
                {{ form.errors.area }}
            </div>
        </div>
  
        <div class="col-span-4">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">City</label>
          <input type="text" v-model.number="form.city" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.city">
                {{ form.errors.city }}
            </div>
        </div>
  
        <div class="col-span-2">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Post Code</label>
          <input type="text" v-model.number="form.code" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.code">
                {{ form.errors.code }}
            </div>
        </div>
  
        <div class="col-span-4">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Street</label>
          <input type="text" v-model.number="form.street" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.street">
                {{ form.errors.street }}
            </div>
        </div>
  
        <div class="col-span-2">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Street Nr</label>
          <input type="text" v-model.number="form.street_nr" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.street_nr">
                {{ form.errors.street_nr }}
            </div>
        </div>
  
        <div class="col-span-6">
          <label class="block mb-1 text-gray-500 dark:text-gray font-medium">Price</label>
          <input type="text" v-model.number="form.price" class="block w-full p-2 rounded-md shadow-sm border border-gray-300 dark:border-gray-600 text-gray-500"/>
            <div v-if="form.errors.price">
                {{ form.errors.price }}
            </div>
        </div>
  
        <div class="col-span-6">
          <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium p-2 rounded-md">Create</button>
        </div>
      </div>
    </form>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3'


    const form = useForm({
        beds: 0,
        baths: 0,
        area: 0,
        city: null,
        street: null,
        code: null,
        street_nr: null,
        price: 0,
    })

    const create = () => form.post(route('listing.store'), form)

</script>
  
  <style scoped>
  label {
    margin-right: 2em;
  }
  
  div {
    padding: 2px
  }
  </style>