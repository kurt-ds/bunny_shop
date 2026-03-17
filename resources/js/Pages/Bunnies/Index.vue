<template>
    <div class="p-6">
        <h1>Bunnies</h1>

        <div v-if="loading">Loading from API...</div>

        <div v-else>
            <div v-for="bunny in bunnies" :key="bunny.id" class="border-b mb-4">
                <h2>{{ bunny.name }}</h2>
                <div v-html="bunny.description"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const bunnies = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const response = await axios.get('/api/bunnies');


        bunnies.value = response.data.data;

        console.log (bunnies);
    } catch (error) {
        console.error("Fetch failed", error);
    } finally {
        loading.value = false;
    }
});
</script>