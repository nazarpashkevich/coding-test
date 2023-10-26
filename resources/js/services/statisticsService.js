
const userStatistics = async () => {
    const response = await axios.get('/api/statistics/users-tasks')

    return response.data
}

const weekCompletedTasks = async () => {
    const response = await axios.get('/api/statistics/week-completed-tasks-count')

    return response.data
}


const monthCompletedTasks = async () => {
    const response = await axios.get('/api/statistics/month-completed-tasks-count')

    return response.data
}

export { userStatistics, weekCompletedTasks, monthCompletedTasks }
