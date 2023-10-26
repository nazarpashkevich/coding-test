<template>
    <statistic-week-completed-card :class="'mt-8 lg:mt-0'" />
    <statistic-month-completed-card />
</template>

<script setup>

import StatisticWeekCompletedCard from "./components/StatisticWeekCompletedCard.vue";
import StatisticMonthCompletedCard from "./components/StatisticMonthCompletedCard.vue";
</script>
