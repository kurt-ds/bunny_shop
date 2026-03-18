<template>
    <Main>
        <div class="text-secondary flex gap-3 text-lg font-bold">
            <svg
                width="800px"
                height="800px"
                viewBox="0 0 24 24"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
            >
                <path
                    d="M11 8C11 7.44772 11.4477 7 12 7C12.5523 7 13 7.44772 13 8V11H16C16.5523 11 17 11.4477 17 12C17 12.5523 16.5523 13 16 13H13V16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16V13H8C7.44771 13 7 12.5523 7 12C7 11.4477 7.44772 11 8 11H11V8Z"
                    fill="#currentColor"
                />
                <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM3.00683 12C3.00683 16.9668 7.03321 20.9932 12 20.9932C16.9668 20.9932 20.9932 16.9668 20.9932 12C20.9932 7.03321 16.9668 3.00683 12 3.00683C7.03321 3.00683 3.00683 7.03321 3.00683 12Z"
                    fill="#currentColor"
                />
            </svg>
            Add new Breed
        </div>

        <div class="w-full h-96 flex gap-5 items-center justify-center">
            <form
                @submit.prevent="handleSubmit"
                class="p-6 shadow-xl rounded-xl flex flex-col gap-5"
            >
                <input
                    v-model="breedName"
                    type="text"
                    placeholder="Breed Name"
                />

                <textarea
                    v-model="description"
                    name="description"
                    id="description"
                    placeholder="Describe the breed here..."
                ></textarea>

                <button
                    type="submit"
                    class="p-3 bg-tertiary text-white font-bold rounded-xl hover:bg-red-400 ease-in"
                >
                    ADD
                </button>
            </form>
        </div>
    </Main>
</template>

<script setup>
import { ref } from "vue";
import Main from "../Layout/Main.vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const breedName = ref("");
const description = ref("");

const handleSubmit = async () => {
    const data = new FormData();

    data.append("name", breedName.value);
    data.append("description", description.value);

    try {
        const response = await axios.post("/api/categories", data);

        console.log("Success", response.data);

        router.visit("/categories");
    } catch (e) {
        console.error("Breed add failed", e.response?.data || e.message);
        alert("Check to form for errors!");
    }
};
</script>
