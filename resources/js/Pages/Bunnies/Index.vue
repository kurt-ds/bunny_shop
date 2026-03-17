<template>
    <Main>
        <div class="p-6">
            <h1>Bunnies</h1>

            <BunnyList :bunnies="bunnies" :loading="loading" />
        </div>
    </Main>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Main from "../Layout/Main.vue";
import BunnyList from "@/Components/Bunny/BunnyList.vue";

const bunnies = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const response = await axios.get("/api/bunnies");

        bunnies.value = response.data.data;
    } catch (error) {
        console.error("Fetch failed", error);
    } finally {
        loading.value = true;
    }
});
</script>
