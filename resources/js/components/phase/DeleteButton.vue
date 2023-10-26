<template>
    <div class="w-full flex items-center justify-between bg-white text-red-900 hover:cursor-pointer shadow-md
         rounded-lg p-3 relative border border-red-900 hover:bg-red-50"
         @click="showConfirmation">
        <span>Delete this phase!</span>
        <TrashIcon class="h-6 w-6" aria-hidden="true"/>
    </div>
    <generic-modal v-if="showDeleteConfirmation" @close="hideConfirmation">
        <div class="text-xl font-semibold mb-4">Confirm Deletion</div>
        <p class="text-gray-700 mb-4">Are you sure you want to delete this item?</p>
        <div class="flex justify-end">
            <button class="bg-red-700 hover:bg-red-900 text-white py-2 px-4 rounded mr-2" @click="deleteAction">
                Delete
            </button>
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded" @click="hideConfirmation">
                Cancel
            </button>
        </div>
    </generic-modal>
</template>

<script setup>
import { TrashIcon } from '@heroicons/vue/20/solid'
import { ref } from "vue";

const showDeleteConfirmation = ref(false)
const props = defineProps({
    action: {
        type: Function,
        required: true
    }
})

const showConfirmation = () => {
    showDeleteConfirmation.value = true
}

const hideConfirmation = () => {
    showDeleteConfirmation.value = false
}

const deleteAction = () => {
    hideConfirmation()
    props.action()
}
</script>
