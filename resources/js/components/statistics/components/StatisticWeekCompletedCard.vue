<template>
    <statistic-small-card title="New week tasks" description="new tasks on this week" :value="weekStatValue"/>
</template>

<script setup>
import StatisticSmallCard from "./StatisticSmallCard.vue";
import { onMounted, ref } from "vue";
import { weekCompletedTasks } from "../../../services/statisticsService.js";

const weekStatValue = ref(0)

const getWeekStat = async () => {
    const stat = await weekCompletedTasks()
    weekStatValue.value = stat.count;
}

onMounted(() => {
    getWeekStat()
})
</script>
