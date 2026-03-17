<template>
    <nav class="bg-primary py-4 px-10 text-white flex justify-between">
        <div class="title flex gap-2 items-center">
            <img
                src="/assets/carrot.svg"
                class="fill-white h-6"
                alt="Carrot Icon"
            />
            <h1 class="font-bold text-lg">The Cozy Burrow</h1>
        </div>

        <div class="block nav-links flex gap-3">
            <a
                v-for="link in links"
                href="#"
                class="block relative text-lg font-medium text-white transition duration-300 ease-in-out group"
            >
                {{ link }}
                <span
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"
                ></span>
            </a>
        </div>
    </nav>
</template>

<script setup>
const links = ["Shop", "About", "Adopt", "Blog"];
</script>
