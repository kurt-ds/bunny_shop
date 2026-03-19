<template>
    <Main>
        <div class="p-6 flex justify-between">
            <div class="text-secondary flex gap-3 text-lg font-bold">
                <svg
                    width="800px"
                    height="800px"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M12.7848 0.449982C13.8239 0.449982 14.7167 1.16546 14.9122 2.15495L14.9991 2.59495C15.3408 4.32442 17.1859 5.35722 18.9016 4.7794L19.3383 4.63233C20.3199 4.30175 21.4054 4.69358 21.9249 5.56605L22.7097 6.88386C23.2293 7.75636 23.0365 8.86366 22.2504 9.52253L21.9008 9.81555C20.5267 10.9672 20.5267 13.0328 21.9008 14.1844L22.2504 14.4774C23.0365 15.1363 23.2293 16.2436 22.7097 17.1161L21.925 18.4339C21.4054 19.3064 20.3199 19.6982 19.3382 19.3676L18.9017 19.2205C17.1859 18.6426 15.3408 19.6754 14.9991 21.405L14.9122 21.845C14.7167 22.8345 13.8239 23.55 12.7848 23.55H11.2152C10.1761 23.55 9.28331 22.8345 9.08781 21.8451L9.00082 21.4048C8.65909 19.6754 6.81395 18.6426 5.09822 19.2205L4.66179 19.3675C3.68016 19.6982 2.59465 19.3063 2.07505 18.4338L1.2903 17.1161C0.770719 16.2436 0.963446 15.1363 1.74956 14.4774L2.09922 14.1844C3.47324 13.0327 3.47324 10.9672 2.09922 9.8156L1.74956 9.52254C0.963446 8.86366 0.77072 7.75638 1.2903 6.8839L2.07508 5.56608C2.59466 4.69359 3.68014 4.30176 4.66176 4.63236L5.09831 4.77939C6.81401 5.35722 8.65909 4.32449 9.00082 2.59506L9.0878 2.15487C9.28331 1.16542 10.176 0.449982 11.2152 0.449982H12.7848ZM12 15.3C13.8225 15.3 15.3 13.8225 15.3 12C15.3 10.1774 13.8225 8.69998 12 8.69998C10.1774 8.69998 8.69997 10.1774 8.69997 12C8.69997 13.8225 10.1774 15.3 12 15.3Z"
                        fill="currentColor"
                    />
                </svg>
                Manage Hopper Breeds
            </div>

            <Link
                href="/categories/create"
                class="flex items-center gap-3 bg-tertiary text-white px-4 py-2 font-bold rounded-lg hover:bg-red-400 ease-in text-center"
            >
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
                Add Breed
            </Link>
        </div>

        <div
            v-if="loading"
            class="flex font-bold items-center justify-center"
            style="height: 40vh"
        >
            Loading from API...
        </div>

        <div
            v-else
            class="max-w-4xl mx-auto mt-8 overflow-hidden bg-white shadow-xl rounded-xl border border-gray-100"
        >
            <table class="mx-auto text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th
                            class="px-6 py-4 text-sm font-semibold text-gray-700 uppercase tracking-wider"
                        >
                            Breed Name
                        </th>
                        <th
                            class="hidden md:table-cell px-6 py-4 text-sm font-semibold text-gray-700 uppercase tracking-wider"
                        >
                            Description
                        </th>
                        <th
                            class="px-6 py-4 text-sm font-semibold text-gray-700 uppercase tracking-wider text-center"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr
                        v-for="category in categories"
                        :key="category.id"
                        class="hover:bg-gray-50 transition-colors"
                    >
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ category.name }}
                        </td>
                        <td
                            class="hidden md:table-cell px-6 py-4 text-gray-600 text-sm italic"
                        >
                            {{ category.description }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-3">
                                <Link
                                    :href="`/categories/${category.id}/edit`"
                                    class="px-4 py-1.5 text-blue-500 rounded-lg hover:text-blue-800 transition-all"
                                >
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
                                </Link>
                                <button
                                    @click="
                                        () => {
                                            deleteCategory(category.id);
                                        }
                                    "
                                    class="px-4 py-1.5 text-red-500 rounded-lg hover:text-red-800 transition-all"
                                >
                                    <svg
                                        width="800px"
                                        height="800px"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-red-400"
                                    >
                                        <path
                                            d="M10 12V17"
                                            stroke="#FF0000"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                        <path
                                            d="M14 12V17"
                                            stroke="#FF0000"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                        <path
                                            d="M4 7H20"
                                            stroke="#FF0000"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                        <path
                                            d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10"
                                            stroke="#FF0000"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                        <path
                                            d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                            stroke="#FF0000"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Main>
</template>

<script setup>
import axios from "axios";
import Main from "../Layout/Main.vue";
import { router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const categories = ref([]);
const loading = ref(true);

const deleteCategory = async (id) => {
    if (confirm("Are you sure you want to delete this breed?")) {
        try {
            const response = await axios.delete(`/api/categories/${id}`);

            console.log(response.data);
            if (response.data.success) {
                router.visit("/categories");
            }
        } catch (e) {
            console.error("Something went wrong", e.response?.data || e);
            alert("The server refused to remove the breed!");
        }
    }
};

const fetchCategories = async () => {
    try {
        const response = await axios.get("/api/categories");
        categories.value = response.data.data;
        console.log(categories.value);
    } catch (error) {
        console.log("Fetch failed", error);
    } finally {
        loading.value = false;
    }
};

onMounted(fetchCategories);
</script>
