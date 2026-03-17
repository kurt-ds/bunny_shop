<template>
    <h2>{{ bunny.name }}</h2>
    <div v-html="bunny.description"></div>
</template>

<script setup>
defineProps({
    bunny: Object,
});
</script>
