<template>
    <div
        v-if="loading"
        class="font-bold w-[60vw] min-h-[50vh] flex items-center justify-center"
    >
        <div class="flex flex-col items-center gap-2">
            <span class="animate-bounce">🐰</span>
            <span>Loading from API...</span>
        </div>
    </div>

    <div
        v-else-if="bunnies && bunnies.length > 0"
        class="flex flex-col gap-8 w-[60vw]"
    >
        <div class="flex flex-wrap justify-center gap-6">
            <BunnyCard
                v-for="bunny in bunnies"
                :key="bunny.id"
                :bunny="bunny"
                class="w-full sm:w-[calc(50%-1.5rem)] lg:w-[calc(33.333%-1.5rem)]"
            />
        </div>

        <div class="flex flex-col items-center gap-4">
            <div v-if="pagination?.meta" class="text-sm text-gray-500 italic">
                Showing {{ pagination.meta.from }} to
                {{ pagination.meta.to }} of {{ pagination.meta.total }} bunnies
            </div>

            <Pagination
                :pagination="pagination"
                :perPage="perPage"
                @change-page="$emit('change-page', $event)"
                @update:perPage="$emit('update:perPage', $event)"
            />
        </div>
    </div>

    <div
        v-else
        class="font-bold w-[60vw] min-h-[50vh] flex items-center justify-center"
    >
        No bunnies in the burrow!
    </div>
</template>

<script setup>
import BunnyCard from "./BunnyCard.vue";
import Pagination from "../Pagination.vue";

// Changed variable name to 'props' (standard convention)
const props = defineProps({
    bunnies: Array,
    loading: Boolean,
    perPage: Number,
    pagination: Object,
});

// Added update:perPage to ensure your dropdown works
defineEmits(["change-page", "update:perPage"]);
</script>
