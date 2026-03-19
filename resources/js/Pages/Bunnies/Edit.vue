<template>
    <Main>
        <form
            @submit.prevent="handleSubmit"
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
                        class="w-full"
                        :class="{ 'ring-1 ring-red-500': errors.description }"
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
                    class="bg-tertiary text-white p-3 rounded-xl hover:bg-red-400 font-bold"
                >
                    Update
                </button>
            </div>
        </form>
    </Main>
</template>

<script setup>
const props = defineProps({
    id: String,
});

import axios from "axios";
import Main from "../Layout/Main.vue";
import { onMounted, ref } from "vue";
import ImageUploader from "@/Components/ImageUploader.vue";
import { router } from "@inertiajs/vue3";

const loading = ref(true);
const categories = ref([]);
const imageFile = ref(null);
const bunny = ref(null);

const formData = ref({
    category_id: 0,
    name: "",
    price: null,
    age_months: null,
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
    } else if (formData.value.price <= 0) {
        e.price = "Price must be more than 0.";
    } else if (formData.value.price > 99999.99) {
        e.price = "Price must not exceed 99,999.99.";
    }

    if (
        formData.value.age_months === "" ||
        formData.value.age_months === null
    ) {
        e.age_months = "Age is required.";
    } else if (formData.value.age_months <= 0) {
        e.age_months = "Age must be more than 0.";
    } else if (formData.value.age_months > 240) {
        e.age_months = "Age must not exceed 240 months.";
    }

    if (!formData.value.gender) {
        e.gender = "Please select a gender.";
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

const fetchData = async () => {
    try {
        const response1 = await axios.get("/api/categories");
        const response2 = await axios.get(`/api/bunnies/${props.id}`);
        bunny.value = response2.data.data;

        categories.value = response1.data.data;

        formData.value = {
            category_id: bunny.value.category_id,
            name: bunny.value.name,
            price: bunny.value.price,
            age_months: bunny.value.age,
            gender: bunny.value.gender,
            image_url: `/storage/${bunny.value.image_url}`,
            description: bunny.value.description,
        };
    } catch (error) {
        console.log("Fetch failed", error);
    } finally {
        loading.value = false;
    }
};

const handleSubmit = async () => {
    if (!validate()) return;

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

    data.append("_method", "PUT");

    try {
        const response = await axios.post(`/api/bunnies/${props.id}`, data);

        console.log("Success", response.data);

        router.visit("/");
    } catch (e) {
        console.error("Upload failed", e.response?.data || e.message);
        alert("Check the form for errors!");
    }
};

onMounted(fetchData);
</script>
