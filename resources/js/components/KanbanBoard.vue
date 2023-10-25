<template>
    <div class="max-w-7xl flex-1 mx-auto flex flex-col overflow-auto sm:px-6 lg:px-8">
        <div class="w-full mb-6 flex">
            <Teleport to="body">
                <generic-modal :show="kanban.showTaskForm" @close="kanban.hideTaskForm" key="createTaskModal">
                    <task-form @post-action="refreshTasks" />
                </generic-modal>
            </Teleport>
        </div>

        <div id="kanban-container" class="flex-1 flex overflow-auto scrollbar-hide shadow-lg">
            <div class="text-gray-900">
                <div class="h-full flex overflow-x-auto overflow-y-auto space-x-4">
                    <task-column v-for="col in kanban.phases"
                                 :phase_id="col.id"
                                 :tasks_count="col.tasks_count"
                    >
                    </task-column>
                </div>
            </div>
        </div>

        <!-- Modal to edit the selected card -->
        <Teleport to="body">
            <generic-modal v-if="kanban.hasSelectedTask()" @close="kanban.unselectTask()">
                <div class="relative">
                    <TrashIcon class="w-6 h-6 absolute top-0 right-0 hover:cursor-pointer" @click="deleteCard(kanban.selectedTask.id)" />
                    <div class="flex justify-center">
                        <img class="w-16 h-16 shadow-lg rounded-full border-2 border-blue-800"
                            :src="getAvatar(kanban.selectedTask.user)" :alt="kanban.selectedTask.user.name" />
                    </div>
                    <div class="mt-3 sm:mt-5">
                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">{{ kanban.selectedTask.name }}</DialogTitle>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">In column {{ kanban.phases[kanban.selectedTask.phase_id].name
                            }}</p>
                            <p class="text-sm text-gray-500">Assigned to {{ kanban.selectedTask.user.name }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md border-blue-600 text-blue-600 border px-3
                         py-2 text-sm font-semibold shadow-sm hover:bg-blue-100 focus-visible:outline
                          focus-visible:outline-2 focus-visible:outline-blue-300"
                        @click="kanban.editTask(kanban.selectedTask)">Edit</button>
                </div>
                <div class="mt-2">
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold
                        text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2
                         focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                        @click="kanban.unselectTask()">Close</button>
                </div>
            </generic-modal>
        </Teleport>

    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { useKanbanStore } from '../stores/kanban'
import { DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { sha256 } from 'js-sha256';
import TaskForm from "./task/TaskForm.vue";


const kanban = useKanbanStore()
const selected = ref(null)

const getAvatar = function (user) {
    if (user.profile_picture_url !== null) {
        return user.profile_picture_url;
    } else {
        return ("https://www.gravatar.com/avatar/" + sha256(String(user.email).trim().toLowerCase()) + "?size=400");
    }
}

// Define these functions outside of onMounted so they're in the component's scope
let pos = { top: 0, left: 0, x: 0, y: 0 };
let ele;

const mouseDownHandler = function (e) {
    ele.style.cursor = 'grabbing';
    ele.style.userSelect = 'none';

    pos = {
        left: ele.scrollLeft,
        top: ele.scrollTop,
        x: e.clientX,
        y: e.clientY,
    };

    document.addEventListener('mousemove', mouseMoveHandler);
    document.addEventListener('mouseup', mouseUpHandler);
};

const mouseMoveHandler = function (e) {
    const dx = e.clientX - pos.x;
    const dy = e.clientY - pos.y;

    ele.scrollTop = pos.top - dy;
    ele.scrollLeft = pos.left - dx;
};

const mouseUpHandler = function () {
    ele.style.cursor = 'grab';
    ele.style.removeProperty('user-select');

    document.removeEventListener('mousemove', mouseMoveHandler);
    document.removeEventListener('mouseup', mouseUpHandler);
};

const refreshTasks = async () => {
    try {
        const response = await axios.get('/api/tasks');
        const originalTasks = response.data;
        kanban.phases = originalTasks.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the tasks!', error);
    }
}

const refreshUsers = async () => {
    try {
        const response = await axios.get('/api/users');
        const originalUsers = response.data;
        // rekey originalUsers to use the id property in the objects as the array key
        kanban.users = originalUsers.reduce((acc, cur) => {
            acc[cur.id] = cur;
            return acc;
        }, {});
    } catch (error) {
        console.error('There was an error fetching the users!', error);
    }
}

const getSelf = async () => {
    try {
        const response = await axios.get('/api/user');
        kanban.self = response.data;
        if (kanban.taskProps.user_id === null) {
            kanban.taskProps.user_id = kanban.self.id;
        }
        if (kanban.self.profile_picture_url === null) {
            kanban.self.profile_picture_url = getAvatar(kanban.self)
        }
    } catch (error) {
        console.error('There was an error fetching the logged in user!', error);
    }
}

const deleteCard = async (id) => {
    try {
        const response = await axios.delete('/api/tasks/' + id);
        await refreshTasks();
        kanban.unselectTask();
    } catch (error) {
        console.error('There was an error deleting the task!', error);
    }
}

onMounted(async () => {

    await refreshTasks();
    await refreshUsers();
    await getSelf();

    await nextTick();

    ele = document.getElementById('kanban-container');
    if (ele) {
        ele.style.cursor = 'grab';
        ele.addEventListener('mousedown', mouseDownHandler);
    }

})

onUnmounted(() => {
    if (ele) {
        // Clean up the event listener when the component is unmounted.
        ele.removeEventListener('mousedown', mouseDownHandler);
    }
})
</script>

<style scoped>/* For Webkit-based browsers (Chrome, Safari and Opera) */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

/* For IE, Edge and Firefox */
.scrollbar-hide {
    -ms-overflow-style: none;
    /* IE and Edge */
    scrollbar-width: none;
    /* Firefox */
}</style>
