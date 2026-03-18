<template>
    <div
        class="w-[280px] shadow-2xl text-secondary p-4 rounded-xl flex flex-col gap-2"
    >
        <img
            :src="`/storage/${bunny.image_url}`"
            alt="{{ bunny.name }}'s' Image"
            @error="setDefaultImage"
            class="rounded-lg w-full h-[185px] object-cover"
        />
        <h2 class="font-bold">{{ bunny.name }}</h2>
        <p class="text-sm">
            {{ bunny.category_name }} &bull; {{ bunny.age }} months
        </p>
        <p class="text-lg font-bold text-tertiary">&dollar;{{ bunny.price }}</p>

        <Link
            :href="`/bunnies/${bunny.id}`"
            class="bg-tertiary text-white font-bold p-2 rounded-lg text-center"
        >
            View Details
        </Link>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted } from "vue";

defineProps({
    bunny: Object,
});

const setDefaultImage = (e) => {
    e.target.src = "/storage/bunnies/placeholder.jpg";
};
</script>
