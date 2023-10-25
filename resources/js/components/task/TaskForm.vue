<template>
    <div>
        <div class="mt-3 sm:mt-2">
            <DialogTitle as="h3" class="mb-6 text-base font-semibold leading-6 text-gray-900">{{ title }}</DialogTitle>
            <div>
                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Task description</label>
                <div class="relative mt-2">
                    <input type="text" v-model="kanban.taskProps.name" id="name"
                           class="peer block w-full border-0 bg-gray-50 py-1.5 text-gray-900 focus:ring-0 sm:text-sm sm:leading-6"
                           placeholder="Make it productive, but also fun!" />
                    <p v-if="hasError('name')"
                       class="mt-2 text-sm text-red-600"
                       id="name-error">
                        {{ getError('name') }}
                    </p>
                    <div class="absolute inset-x-0 bottom-0 border-t border-gray-300 peer-focus:border-t-2 peer-focus:border-blue-600"
                         aria-hidden="true"></div>
                </div>
            </div>

            <Listbox as="div" v-model="kanban.taskProps.user_id" class="mt-8">
                <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Assigned to</ListboxLabel>
                <div class="relative mt-2">
                    <ListboxButton
                        class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm sm:leading-6">
                        <span class="flex items-center">
                            <img :src="getAvatarByUser(kanban.users[kanban.taskProps.user_id || kanban.self.id])"
                                 alt=""
                                 class="h-5 w-5 flex-shrink-0 rounded-full"
                            />
                            <span class="ml-3 block truncate">{{ kanban.users[kanban.taskProps.user_id || kanban.self.id].name }}</span>
                        </span>
                        <span
                            class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </span>

                    </ListboxButton>

                    <transition leave-active-class="transition ease-in duration-100"
                                leave-from-class="opacity-100" leave-to-class="opacity-0">
                        <ListboxOptions
                            class="absolute z-20 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ListboxOption as="template" v-for="person in kanban.users" :key="person.id"
                                           :value="person.id" v-slot="{ active, selected }">
                                <li :class="[active ? 'bg-blue-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                    <div class="flex items-center">
                                        <img :src="getAvatarByUser(person)" alt="{{ person.name }}"
                                             class="h-5 w-5 flex-shrink-0 rounded-full" />
                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">{{ person.name }}</span>
                                    </div>

                                    <span v-if="selected"
                                          :class="[active ? 'text-white' : 'text-blue-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                        <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                    </span>
                                </li>
                            </ListboxOption>
                        </ListboxOptions>
                    </transition>
                </div>
            </Listbox>

            <div class="mt-8">
                <label for="taskPhase" class="block text-sm font-medium leading-6 text-gray-900">Phase</label>
                <select v-model="kanban.taskProps.phase_id" id="taskPhase" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                    <option v-for="phase in kanban.phases" :key="phase.id" :value="phase.id">{{ phase.name }}</option>
                </select>
            </div>

        </div>

        <div class="mt-5 sm:mt-6">
            <button type="button"
                    class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                    @click="submitForm()"
            >{{ actionButtonTitle }}</button>
        </div>
    </div>

</template>

<script setup>
import { DialogTitle, Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import { computed, ref } from "vue";
import { useKanbanStore } from "../../stores/kanban.js";
import { createTask, updateTask, getAvatarByUser } from "../../services/taskService.js";

const emit = defineEmits(['post-action'])

const kanban = useKanbanStore()

const errors = ref(null)

const isEditMode = computed(() => kanban.taskProps.id > 0)

const title = computed(() => isEditMode.value ? `Edit task #${kanban.taskProps.id}` : 'Create a new task')
const actionButtonTitle = computed(() => isEditMode.value ? `Update a card!` : 'Add the card!')

const getError = function (field) {
    if (errors.value && errors.value[field]) {
        return errors.value[field][0].message;
    }
    return null;
}

const hasError = function (field) {
    return errors.value && errors.value[field];
}

const submitForm = async () => {
    try {
        isEditMode.value ? await updateTask(kanban.taskProps.id, kanban.taskProps) : await createTask(kanban.taskProps)

        kanban.hideTaskForm()

        emit('post-action')
    } catch (error) {
        if (error.response.status === 422) {
            errors.value = error.response.data.errors;
        }
    }
}
</script>
