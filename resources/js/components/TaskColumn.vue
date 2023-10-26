<template>
<div class="w-[300px] bg-sky-950 rounded-lg shadow-lg">
    <div class="p-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg text-zinc-100 font-black mb-3">
                {{ kanban.phases[props.phase_id].name }} ({{ tasks_count }})
            </h2>
            <PlusIcon
                @click="createTask()"
                class="mb-3 h-6 w-6 text-white hover:cursor-pointer"
                aria-hidden="true" />
        </div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-white">Is complete phase</span>
            <input type="checkbox"
                   class="mr-[2px] rounded-md w-5 h-5 rounded border-gray-200 text-indigo-600 shadow-sm
                    focus:ring-sky-900"
                   v-model="completable"
                   v-on:change="markCompletable">
        </div>
        <task-card
            v-if="kanban.phases[props.phase_id].tasks.length > 0"
            v-for="task in kanban.phases[props.phase_id].tasks"
            :task="task"
        />

        <!-- A card to create a new task -->
        <div class="w-full flex items-center justify-between bg-white text-gray-900 hover:cursor-pointer shadow-md
         rounded-lg p-3 relative mb-4"
            @click="createTask()">
            <span>Create a new task</span>
            <PlusIcon class="h-6 w-6" aria-hidden="true" />
        </div>

        <!-- A card to create a new task -->
        <div class="w-full flex items-center justify-between bg-white text-red-900 hover:cursor-pointer shadow-md
         rounded-lg p-3 relative border border-red-900 hover:bg-red-50"
            @click="deletePhaseAction">
            <span>Delete this phase!</span>
            <TrashIcon class="h-6 w-6" aria-hidden="true" />
        </div>

    </div>
</div>
</template>

<script setup>
// get the props
import { useKanbanStore } from '../stores/kanban'
import { PlusIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { deletePhase, setPhaseCompletable } from "../services/phaseService.js";
import { ref } from 'vue'
const kanban = useKanbanStore()

const props = defineProps({
    phase_id: {
        type: Number,
        required: true
    },
    tasks_count: {
        type: Number,
        required: true
    },
    is_completable: {
        type: Boolean,
        required: true
    },
})

const emit = defineEmits(['updated'])

const createTask = function () {
    kanban.showTaskForm = true;
    kanban.taskProps.phase_id = props.phase_id;
}

const completable = ref(props.is_completable)

const markCompletable = () => {
    setPhaseCompletable(props.phase_id, completable.value)

    emit('updated')
}

const deletePhaseAction = () => {
    deletePhase(props.phase_id)

    emit('updated')
}
</script>
