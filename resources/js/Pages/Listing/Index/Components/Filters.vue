<template>

    <form action="">
        <div class="mb-8 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center">
                <input type="text" placeholder="Price From" class="input-filter-l w-28"/>
                <input type="text" placeholder="Price To" class="input-filter-r w-28"/>
            </div>

            <div class="flex flex-nowrap items-center">
                <select name="" id="" class="input-filter-l w-28">
                    <option :value="null">Beds</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>

                <select name="" id="" class="input-filter-r w-28">
                    <option :value="null">Baths</option>
                    <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
                    <option>6+</option>
                </select>
            </div>

            <div class="flex flex-nowrap items-center">
                <input type="text" placeholder="Area From" class="input-filter-l w-28"/>
                <input type="text" placeholder="Area To" class="input-filter-r w-28"/>
            </div>
            
            <button type="submit" class="btn-normal">Filter</button>
            <button type="reset">Clear</button>
        </div>
    </form>

</template>