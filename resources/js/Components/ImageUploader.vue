<template>
    <div>
        <input type="file" @change="handleFileChange" accept=".jpg, .jpeg, .png" " />
    </div>
</template>

<script setup>
const emit = defineEmits(["image-selected"]);

const handleFileChange = (event) => {
    const file = event.target.files[0];

    if (file) {
        emit("image-selected", file);
    }
};
</script>
