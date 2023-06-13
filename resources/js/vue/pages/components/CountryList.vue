<script setup>
import Country from "./Country.vue";

defineProps(['countries']);
defineEmits(['delete-country'])
</script>

<template>
    <div class="border-t mt-3">
        <div class="flex flex-row py-3 border-b text-slate-100 bg-gray-400 font-bold">
            <div class="basis-1/2 pl-3">Country name</div>
            <div class="basis-1/2">Country capital</div>
            <div class="text-right pr-3">Delete</div>
        </div>
        <Country v-for="country in countries" :country="country" />
    </div>
</template>
