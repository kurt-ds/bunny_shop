<template>
    <div
        v-if="loading"
        class="font-bold w-[60vw] min-h-[50vh] flex items-center justify-center"
    >
        Loading from API...
    </div>

    <div
        v-else-if="bunnies.length > 0"
        class="flex flex-col gap-5 w-[60vw] items-center"
    >
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <BunnyCard
                v-for="bunny in bunnies"
                :key="bunny.id"
                :bunny="bunny"
            />
        </div>
        <Pagination
            :pagination="pagination"
            @change-page="$emit('change-page', $event)"
        />
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

const changePage = defineProps({
    bunnies: Array,
    loading: Boolean,
    pagination: Object,
});

defineEmits(["change-page"]);
</script>
