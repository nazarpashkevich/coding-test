<template>
    <statistic-small-card title="New month tasks" description="new tasks on this month" :value="monthStatValue"/>
</template>

<script setup>
import StatisticSmallCard from "./StatisticSmallCard.vue";
import { onMounted, ref } from "vue";
import { monthCompletedTasks } from "../../../services/statisticsService.js";

const monthStatValue = ref(0)

const getMonthStat = async () => {
    const stat = await monthCompletedTasks()
    monthStatValue.value = stat.count;
}

onMounted(() => {
    getMonthStat()
})
</script>
