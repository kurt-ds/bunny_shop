<template>
    <div
        v-if="loading"
        class="font-bold min-h-[50vh] flex items-center justify-center"
    >
        Loading from API...
    </div>

    <div v-else-if="bunnies.length > 0" class="flex gap-2">
        <BunnyCard v-for="bunny in bunnies" :key="bunny.id" :bunny="bunny" />
    </div>

    <div v-else class="font-bold min-h-[50vh] flex items-center justify-center">
        No bunnies in the burrow!
    </div>
</template>

<script setup>
import BunnyCard from "./BunnyCard.vue";

defineProps({
    bunnies: Array,
    loading: Boolean,
});
</script>
