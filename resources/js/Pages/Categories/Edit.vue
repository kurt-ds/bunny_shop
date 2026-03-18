<template>
    <Main>
        <div class="text-secondary flex gap-3 text-lg font-bold">
            <svg
                width="800px"
                height="800px"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
            >
                <title />

                <g id="Complete">
                    <g id="edit">
                        <g>
                            <path
                                d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8"
                                fill="none"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />

                            <polygon
                                fill="none"
                                points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                            />
                        </g>
                    </g>
                </g>
            </svg>
            Edit Breed
        </div>

        <div
            v-if="loading"
            class="font-bold w-full min-h-[50vh] flex items-center justify-center"
        >
            Loading from API...
        </div>

        <div v-else class="w-full h-96 flex gap-5 items-center justify-center">
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
                    UPDATE
                </button>
            </form>
        </div>
    </Main>
</template>

<script setup>
const props = defineProps({
    id: String,
});
import { onMounted, ref } from "vue";
import Main from "../Layout/Main.vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const breedName = ref("");
const description = ref("");
const category = ref(null);
const loading = ref(true);

const handleSubmit = async () => {
    const data = new FormData();

    data.append("name", breedName.value);
    data.append("description", description.value);

    data.append("_method", "PUT");

    try {
        const response = await axios.post(`/api/categories/${props.id}`, data);

        console.log("Success", response.data);

        router.visit("/categories");
    } catch (e) {
        console.error("Breed update failed", e.response?.data || e.message);
        alert("Check to form for errors!");
    }
};

const fetchCategory = async () => {
    try {
        console.log(props.id);
        const response = await axios.get(`/api/categories/${props.id}`);

        category.value = response.data.data;

        breedName.value = category.value.name;
        description.value = category.value.description;
    } catch (e) {
        console.error("Something went wrong", e);
        alert("Something went wrong! Check your logs");
    } finally {
        loading.value = false;
    }
};

onMounted(fetchCategory);
</script>
