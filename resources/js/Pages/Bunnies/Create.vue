<template>
    <Main>
        <form
            @submit.prevent="handleSubmit"
            class="flex flex-col md:flex-row gap-6 shadow-xl rounded-xl p-4 md:p-8 w-full max-w-4xl mx-auto bg-white overflow-hidden"
        >
            >
            <div class="flex flex-col gap-3 w-full md:w-auto">
                <ImageUploader @image-selected="updatePreview" />
                <p v-if="errors.image" class="text-red-500 text-xs text-center">
                    {{ errors.image }}
                </p>

                <div
                    v-if="formData.image_url"
                    class="w-full h-64 md:h-96 md:w-96 flex flex-col justify-center items-center rounded-xl overflow-hidden shadow-inner"
                >
                    <img
                        :src="formData.image_url"
                        alt="Preview"
                        class="w-full h-full object-cover"
                    />
                </div>

                <div
                    v-else
                    class="w-full h-64 md:h-96 md:w-96 bg-gray-200 flex flex-col justify-center items-center rounded-xl border-2 border-dashed border-gray-400"
                >
                    <p class="text-center text-gray-500 font-medium">
                        Image Preview
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col gap-2 justify-center w-full max-w-4xl mt-7"
            >
                <div>
                    <input
                        v-model="formData.name"
                        type="text"
                        placeholder="Name"
                        @input="errors.name = ''"
                        class="w-full"
                        :class="{ 'ring-1 ring-red-500': errors.name }"
                    />
                    <p v-if="errors.name" class="text-red-500 text-xs mt-0.5">
                        {{ errors.name }}
                    </p>
                </div>

                <div>
                    <select
                        v-model="formData.category_id"
                        name="category"
                        id="category"
                        @change="errors.category_id = ''"
                        class="w-full"
                        :class="[
                            'rounded-md',
                            { 'ring-1 ring-red-500': errors.category_id },
                        ]"
                    >
                        <option v-if="loading" value="" disabled selected>
                            Loading categories...
                        </option>

                        <template v-else>
                            <option value="" selected>
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
                    <p
                        v-if="errors.category_id"
                        class="text-red-500 text-xs mt-0.5"
                    >
                        {{ errors.category_id }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <label class="w-1/2" for="price">Price: </label>
                    <input
                        v-model.number="formData.price"
                        type="number"
                        step="0.01"
                        placeholder="price"
                        @input="errors.price = ''"
                        class="w-full"
                        :class="{ 'ring-1 ring-red-500': errors.price }"
                    />
                    <p v-if="errors.price" class="text-red-500 text-xs mt-0.5">
                        {{ errors.price }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <label class="w-1/2" for="age_months">Age (months): </label>
                    <input
                        v-model.number="formData.age_months"
                        type="number"
                        placeholder="Age in Months"
                        @input="errors.age_months = ''"
                        class="w-full"
                        :class="{ 'ring-1 ring-red-500': errors.age_months }"
                    />
                    <p
                        v-if="errors.age_months"
                        class="text-red-500 text-xs mt-0.5"
                    >
                        {{ errors.age_months }}
                    </p>
                </div>

                <div>
                    <select
                        v-model="formData.gender"
                        name="gender"
                        id="gender"
                        @change="errors.gender = ''"
                        class="w-full"
                        :class="{ 'ring-1 ring-red-500': errors.gender }"
                    >
                        <option value="" disabled selected hidden>
                            Gender
                        </option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <p v-if="errors.gender" class="text-red-500 text-xs mt-0.5">
                        {{ errors.gender }}
                    </p>
                </div>

                <div>
                    <textarea
                        v-model="formData.description"
                        name="description"
                        id="description"
                        placeholder="Describe the bunny"
                        @input="errors.description = ''"
                        :class="{ 'ring-1 ring-red-500': errors.description }"
                        class="w-full"
                    ></textarea>
                    <p
                        v-if="errors.description"
                        class="text-red-500 text-xs mt-0.5"
                    >
                        {{ errors.description }}
                    </p>
                </div>

                <button
                    type="submit"
                    :disabled="submitting"
                    class="bg-tertiary text-white p-3 rounded-xl hover:bg-red-400 font-bold disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {{ submitting ? "Submitting..." : "Sell" }}
                </button>
            </div>
        </form>
    </Main>
</template>

<script setup>
import axios from "axios";
import Main from "../Layout/Main.vue";
import { onMounted, ref } from "vue";
import ImageUploader from "@/Components/ImageUploader.vue";
import { router } from "@inertiajs/vue3";

const loading = ref(true);
const categories = ref([]);
const imageFile = ref(null);
const submitting = ref(false);

const formData = ref({
    category_id: "",
    name: "",
    price: 0,
    age_months: 0,
    gender: "",
    image_url: "",
    description: "",
});

const errors = ref({});

const validate = () => {
    const e = {};

    if (!formData.value.name?.trim()) {
        e.name = "Name is required.";
    } else if (formData.value.name.length > 255) {
        e.name = "Name must not exceed 255 characters.";
    }

    if (!formData.value.category_id || formData.value.category_id == 0) {
        e.category_id = "Please select a breed.";
    }

    if (formData.value.price === "" || formData.value.price === null) {
        e.price = "Price is required.";
    } else if (formData.value.price < 0) {
        e.price = "Price must be at least 0.";
    } else if (formData.value.price > 99999.99) {
        e.price = "Price must not exceed 99,999.99.";
    }

    if (
        formData.value.age_months === "" ||
        formData.value.age_months === null
    ) {
        e.age_months = "Age is required.";
    } else if (formData.value.age_months < 0) {
        e.age_months = "Age must be at least 0.";
    } else if (formData.value.age_months > 240) {
        e.age_months = "Age must not exceed 240 months.";
    }

    if (!formData.value.gender) {
        e.gender = "Please select a gender.";
    }

    if (!imageFile.value) {
        e.image = "Please upload an image.";
    }

    if (!formData.value.description?.trim()) {
        e.description = "Description is required.";
    } else if (formData.value.description.length > 1000) {
        e.description = "Description must not exceed 1000 characters.";
    }

    errors.value = e;
    return Object.keys(e).length === 0;
};

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
    if (!validate()) return;
    if (submitting.value) return;
    submitting.value = true;

    const data = new FormData();

    data.append("category_id", formData.value.category_id);
    data.append("name", formData.value.name);
    data.append("price", formData.value.price);
    data.append("age_months", formData.value.age_months);
    data.append("gender", formData.value.gender);
    data.append("description", formData.value.description);

    if (imageFile.value) {
        data.append("image", imageFile.value);
    }

    try {
        const response = await axios.post("/api/bunnies", data);

        console.log("Success", response.data);

        router.visit("/");
    } catch (e) {
        console.error("Upload failed", e.response?.data || e.message);
        alert("Check the form for errors!");
    } finally {
        submitting.value = false;
    }
};

onMounted(fetchCategories);
</script>
