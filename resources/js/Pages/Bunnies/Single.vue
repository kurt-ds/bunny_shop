<template>
    <Main>
        <div
            v-if="loading"
            class="font-bold min-h-[50vh] flex items-center justify-center"
        >
            Loading from API...
        </div>
        <div
            v-else-if="bunny"
            class="flex flex-col md:flex-row w-full max-w-4xl mx-auto items-center justify-center p-6 rounded-xl shadow-xl gap-5"
        >
            <img
                :src="`/storage/${bunny.image_url}`"
                :alt="`${bunny.name}'s Image'`"
                class="md:h-[400px] object-cover rounded-xl w-full md:w-1/2 flex-shrink-0"
            />
            <div class="flex flex-col gap-2 text-secondary w-full md:w-1/2">
                <h1 class="font-bold text-2xl">{{ bunny.name }}</h1>
                <p class="font-bold text-xl text-tertiary">
                    &dollar;{{ bunny.price }}
                </p>
                <p>
                    {{ bunny.category_name }} &bull; {{ bunny.age }} months
                    &bull;
                    <span class="capitalize"> {{ bunny.gender }} </span>
                </p>
                <p class="leading-relaxed text-gray-700">
                    {{ bunny.description }}
                </p>

                <div>
                    <button
                        class="bg-red-600 text-white p-2 rounded-md hover:bg-red-800 ease-in"
                        @click="releaseBunny"
                    >
                        Release
                    </button>
                </div>
            </div>
        </div>

        <div
            v-else
            class="font-bold min-h-[50vh] flex items-center justify-center"
        >
            This bunny is not available!
        </div>
    </Main>
</template>

<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({
    id: String,
});

import Main from "../Layout/Main.vue";
import axios from "axios";
import { onMounted, ref } from "vue";

const loading = ref(true);
const bunny = ref(null);

const fetchBunny = async () => {
    try {
        const response = await axios.get(`/api/bunnies/${props.id}`);
        bunny.value = response.data.data;
    } catch (error) {
        console.log("Failed fetch of bunny: ", error);
    } finally {
        loading.value = false;
    }
};

const releaseBunny = async () => {
    if (confirm("Are you sure you want to release this bunny to the wild?")) {
        try {
            const response = await axios.delete(`/api/bunnies/${props.id}`);

            if (response.data.success) {
                router.visit("/", {
                    data: { status: "deleted", id: props.id },
                });
            }
        } catch (e) {
            console.error("Something went wrong", e.response?.data || e);
            alert("The server refuse to release the bunny!");
        }
    }
};

onMounted(fetchBunny);
</script>
