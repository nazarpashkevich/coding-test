import { defineStore } from 'pinia'

export const useKanbanStore = defineStore('kanban', {
  state: () => {
    return {
        hoveredName: 'nothing',
        selectedTask: null,
        phases: [],
        users: [],
        showTaskForm: false,
        taskProps: {
          id: null,
          name: '',
          phase_id: null,
          user_id: null,
        },
        self: null,
    }
  },
  actions: {
    unhoverTask() {
      this.hoveredName = 'nothing'
    },
    selectTask(task) {
        this.selectedTask = task
    },
    unselectTask(task) {
        this.selectedTask = null
    },
    hasSelectedTask() {
        return this.selectedTask !== null
    },
    editTask(task) {
        this.unselectTask()
        this.taskProps.id = task.id
        this.taskProps.name = task.name
        this.taskProps.phase_id = task.phase_id
        this.taskProps.user_id = task.user_id
        this.showTaskForm = true
    },
    hideTaskForm() {
        this.refreshTaskProps()
        this.showTaskForm = false
    },
    refreshTaskProps() {
        this.taskProps = {
            id: null,
            name: '',
            phase_id: null,
            user_id: null,
        }
    },
  },
})
