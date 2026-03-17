<template>
    <div v-if="loading" class="font-bold text-center m-10">
        Loading from API...
    </div>

    <div v-else-if="bunnies.length > 0">
        <BunnyCard v-for="bunny in bunnies" :key="bunny.id" :bunny="bunny" />
        <!-- <div v-for="bunny in bunnies" :key="bunny.id" class="border-b mb-4">
            <h2>{{ bunny.name }}</h2>
            <div v-html="bunny.description"></div>
        </div> -->
    </div>

    <div v-else>No bunnies in the burrow!</div>
</template>

<script setup>
import BunnyCard from "./BunnyCard.vue";

defineProps({
    bunnies: Array,
    loading: Boolean,
});
</script>
