<template>
    <div class="min-h-screen flex flex-col">
        <NavBar />

        <main class="flex-grow container mx-auto p-12">
            <slot />
        </main>

        <Footer />
    </div>
</template>

<script setup>
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
</script>
