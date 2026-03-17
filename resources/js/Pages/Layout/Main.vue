<template>
    <div class="min-h-screen flex flex-col">
        <NavBar />

        <main class="flex-grow container mx-auto p-6">
            <slot />
        </main>
    </div>
</template>

<script setup>
import NavBar from "@/Components/NavBar.vue";
</script>
