<template>
    <Main>
        <div
            class="flex flex-col md:flex-row gap-3 shadow-xl rounded-xl p-6 w-fit mx-auto"
        >
            <div class="flex flex-col gap-3">
                <ImageUploader @image-selected="updatePreview" />

                <div
                    v-if="formData.image_url"
                    class="h-96 w-96 flex flex-col justify-center flex-center roundedlg"
                >
                    <img
                        :src="formData.image_url"
                        alt="Preview"
                        class="w-full h-full rounded-xl object-cover"
                    />
                </div>

                <div
                    v-else
                    class="h-96 w-96 bg-gray-500 flex flex-col justify-center flex-center rounded"
                >
                    <p class="text-center w-full text-white">Preview</p>
                </div>
            </div>

            <div class="flex flex-col gap-2 justify-center w-96 mt-7">
                <input v-model="formData.name" type="text" placeholder="Name" />

                <select
                    v-model="formData.category_id"
                    name="category"
                    id="category"
                    class="rounded-md"
                >
                    <option v-if="loading" value="0" disabled selected>
                        Loading categories...
                    </option>

                    <template v-else>
                        <option value="0" selected>
                            Explore the breeds...
                        </option>
                        <option
                            v-for="category in categories"
                            :value="category.id"
                            :key="category.id"
                        >
                            {{ category.name }}
                        </option>
                    </template>
                </select>

                <input
                    v-model.number="formData.price"
                    type="number"
                    step="0.01"
                    placeholder="price"
                />

                <input
                    v-model="formData.age_months"
                    type="number"
                    placeholder="Age in Months"
                />
                <select v-model="formData.gender" name="gender" id="gender">
                    <option value="" disabled selected hidden>Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <textarea
                    v-model="formData.description"
                    name="description"
                    id="description"
                >
Describe the bunny</textarea
                >

                <button
                    @click="handleSubmit"
                    class="bg-tertiary text-white p-3 rounded-xl hover:bg-red-400 font-bold"
                >
                    Donate
                </button>
            </div>
        </div>
    </Main>
</template>

<script setup>
import axios from "axios";
import Main from "../Layout/Main.vue";
import { onMounted, ref, resolveDirective } from "vue";
import ImageUploader from "@/Components/ImageUploader.vue";
import { router } from "@inertiajs/vue3";

const loading = ref(true);
const categories = ref([]);
const imageUrl = ref(null);
const imageFile = ref(null);

const formData = ref({
    category_id: 0,
    name: "",
    price: 0,
    age_months: 0,
    gender: "",
    image_url: "",
    description: "",
});

const updatePreview = (file) => {
    imageFile.value = file;
    formData.value.image_url = URL.createObjectURL(file);
};

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

const handleSubmit = async () => {
    console.log(formData);

    const data = new FormData();

    data.append("category_id", formData.value.category_id);
    data.append("name", formData.value.name);
    data.append("price", formData.value.price);
    data.append("age_months", formData.value.age_months);
    data.append("gender", formData.value.gender);
    data.append("description", formData.value.description);

    if (imageFile) {
        data.append("image", imageFile.value);
    }

    try {
        const response = await axios.post("/api/bunnies", data);

        console.log("Success", response.data);

        router.visit("/");
    } catch (e) {
        console.error("UPload failed", e.response?.data || e.message);
        alert("Check to form for erros!");
    }
};

onMounted(fetchCategories);
</script>
