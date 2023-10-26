<template>
    <h2 class="text-lg font-semibold mb-4">Users assigned tasks</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
        <tr>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3">
                User name
            </th>
            <th scope="col" class="px-6 py-3">
                Count of assigned tasks
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 whitespace-nowrap text-center">
        <tr v-for="user in usersStatistics" :key="user.id">
            <td class="px-6 py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full" :src="getAvatarByUser(user)" alt="">
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ user.name }}</div>
            </td>
            <td class="px-6 py-4">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {{ user.tasks_count }}
                </span>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script setup>
    import { userStatistics } from "../../services/statisticsService.js";
    import { getAvatarByUser } from "../../services/taskService.js";
    import { onMounted, ref } from "vue";

    const usersStatistics = ref([]);

    const getUserStatistic = async () => {
        usersStatistics.value = await userStatistics()
        console.log(usersStatistics.value)
    }

    onMounted(async () => {
        await getUserStatistic();
    })
</script>
