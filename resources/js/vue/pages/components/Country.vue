<script setup>
defineProps(['country'])
</script>

<template>
    <div class="flex flex-row py-3 border-b text-gray-600">
        <div class="basis-1/2 pl-3">{{ country.name }}</div>
        <div class="basis-1/2">{{ country.capital }}</div>
        <div class="pr-3">
            <button
                class="float-right bg-red-400 px-2 text-white font-bold rounded-md hover:bg-red-600"
                @click="$parent.$emit('delete-country', country.id)">&times;
            </button>
        </div>
    </div>
</template>
