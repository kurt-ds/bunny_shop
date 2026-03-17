<template>
    <div>
        <div v-for="bunny in bunnies" :key="bunny.id" >
            <h2>{{ bunny.name  }}</h2>
            <div v-html="bunny.description" ></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted} from 'vue';
import axios from 'axios';


const bunnies = ref([]);


onMounted(async() => {
    const response = await axios.get('/api/bunnies');

    bunnies.value = response.data.data;
});
</script>