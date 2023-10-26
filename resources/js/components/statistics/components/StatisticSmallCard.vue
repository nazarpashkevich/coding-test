<template>
    <div class="bg-white my-4 lg:mx-6 p-6 rounded-xl shadow-lg flex flex-col justify-center">
        <h2 class="text-lg font-semibold mb-4">{{ title }}</h2>
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-800 rounded-full text-xl mr-4">
                {{ value }}
            </div>
            <div><p class="text-sm text-gray-700">{{ description }}</p></div>
        </div>
    </div>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            required: true
        },
        description: {
            type: String,
            required: true
        },
        value: {
            type: Number,
            required: true
        }
    })
</script>
