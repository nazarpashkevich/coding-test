import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'

import Alpine from 'alpinejs';
import TaskCard from './components/TaskCard.vue';
import TaskColumn from './components/TaskColumn.vue';
import TaskForm from './components/task/TaskForm.vue';
import KanbanBoard from './components/KanbanBoard.vue';
import GenericModal from './components/modals/GenericModal.vue';

//statistics
import StatisticUserTable from "./components/statistics/StatisticUserTable.vue";
import StatisticCards from "./components/statistics/StatisticCards.vue";


const pinia = createPinia()
const app = createApp({});
app.use(pinia);

app.component('TaskCard', TaskCard);
app.component('TaskColumn', TaskColumn);
app.component('TaskForm', TaskForm);
app.component('KanbanBoard', KanbanBoard);
app.component('GenericModal', GenericModal);
app.component('StatisticUserTable', StatisticUserTable);
app.component('StatisticCards', StatisticCards);

app.mount("#app");


window.Alpine = Alpine;

Alpine.start();
