<template>
    <div class="flex flex-col gap-2">
        <div class="flex items-center justify-center gap-4">
            <span class="text-sm text-gray-600">Bunnies per page:</span>
            <select
                :value="perPage"
                @change="$emit('update:perPage', Number($event.target.value))"
                name="perPage"
                id="perPage"
                class="appearance-none w-18 border rounded-md bg-white cursor-pointer"
            >
                <option value="3">3</option>
                <option value="6">6</option>
                <option value="12">12</option>
                <option value="24">24</option>
            </select>
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
</template>

<script setup>
const props = defineProps({
    perPage: Number,
    pagination: Object,
});

defineEmits(["change-page", "update:perPage"]);
</script>
