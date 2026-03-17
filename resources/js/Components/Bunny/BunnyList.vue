<template>
    <div
        v-if="loading"
        class="font-bold min-h-[50vh] flex items-center justify-center"
    >
        Loading from API...
    </div>

    <div
        v-else-if="bunnies.length > 0"
        class="flex flex-col gap-5 w-[60vw] items-center"
    >
        <div class="flex gap-2">
            <BunnyCard
                v-for="bunny in bunnies"
                :key="bunny.id"
                :bunny="bunny"
            />
        </div>
        <div class="flex gap-1">
            <button
                @click="$emit('change-page', pagination.links.prev)"
                :disabled="!pagination.links.prev"
                class="hover:bg-tertiary ease-in hover:text-white px-4 py-2 border rounded shadow-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
            >
                &laquo; Prev
            </button>
            <button
                v-for="link in pagination.meta.links.filter(
                    (l) =>
                        !l.label.includes('Next') &&
                        !l.label.includes('Previous'),
                )"
                :key="link.label"
                @click="$emit('change-page', link.url)"
                :disabled="!link.url"
                :class="[
                    'px-4 py-2 border rounded transition',
                    link.active
                        ? 'bg-tertiary  text-white border-primary'
                        : 'hover:bg-tertiary ease-in hover:text-white',
                ]"
                v-html="link.label"
            ></button>

            <button
                @click="$emit('change-page', pagination.links.next)"
                :disabled="!pagination.links.next"
                class="hover:bg-tertiary ease-in hover:text-white px-4 py-2 border rounded shadow-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50"
            >
                Next &raquo;
            </button>
        </div>
    </div>

    <div v-else class="font-bold min-h-[50vh] flex items-center justify-center">
        No bunnies in the burrow!
    </div>
</template>

<script setup>
import BunnyCard from "./BunnyCard.vue";

const changePage = defineProps({
    bunnies: Array,
    loading: Boolean,
    pagination: Object,
});

defineEmits(["change-page"]);
</script>
