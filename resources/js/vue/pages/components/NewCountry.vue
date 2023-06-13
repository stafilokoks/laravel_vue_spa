<script setup>
    import { reactive } from "vue";

    const country = reactive({
        name    : '',
        capital : ''
    })
</script>

<template>
    <form class="pb-3 flex gap-2" method="post" @submit.prevent="$emit('add-country', country)">
        <input
            type="text"
            class="p-2 w-64 border rounded-md"
            v-model="country.name"
            placeholder="Country name"
            required
        />
        <input
            type="text"
            class="p-2 w-64 border rounded-md"
            v-model="country.capital"
            placeholder="Country capital"
            required
        />
        <button class="bg-blue-600 text-white px-5 py-2 rounded-md ml-2 hover:bg-blue-400"
                type="submit">
            Add
        </button>
    </form>
</template>
