<template>
    <div class="rounded-lg shadow-2xl p-5 h-min flex flex-col gap-3 w-[25vw]">
        <input
            v-model="search"
            @change="emitFilters"
            type="text"
            placeholder="Search by name"
        />

        <select
            v-model="categoryInput"
            @change="emitFilters"
            name="categoryInput"
            id="category"
            class="rounded-md"
        >
            <option v-if="loading" value="" disabled selected>
                Loading categories...
            </option>

            <template v-else>
                <option value="" selected>Explore the breeds...</option>
                <option
                    v-for="category in categories"
                    :value="category.id"
                    :key="category.id"
                >
                    {{ category.name }}
                </option>
            </template>
        </select>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const search = ref("");

const categoryInput = ref("");
const categories = ref([]);
const loading = ref(true);

const fetchCategories = async () => {
    try {
        const response = await axios.get("/api/categories");

        categories.value = response.data.data;
    } catch (error) {
        console.log("Fetch failed", error);
    } finally {
        loading.value = false;
    }
};

const emit = defineEmits(["filter-changed"]);

const emitFilters = () => {
    emit("filter-changed", {
        search: search.value,
        category: category.value,
    });
};

onMounted(fetchCategories);
</script>
