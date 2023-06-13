<script setup>
defineProps(['userName'])

</script>

<template>
    <div class="pb-3">
        <div class="flex justify-between">
            <h1 class="text-2xl"> Countries </h1>
            <span class="capitalize">Welcome {{ userName }}, <button
                class="text-orange-500 underline hover:no-underline rounded-md"
                @click="$emit('handle-logout')">Logout</button></span>
        </div>
    </div>
</template>
