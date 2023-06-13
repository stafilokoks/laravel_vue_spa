<script setup>
    defineProps(['errors'])
</script>

<template>
    <ul class="list-disc text-red-400" v-if="typeof errors === 'object'" v-for="(value, index) in errors"
        :key="index"
    >
        <li>{{ value[0] }}</li>
    </ul>
</template>
