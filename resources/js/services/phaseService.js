
const setPhaseCompletable = (id, isCompletable) => axios.put(
    `/api/phases/${id}/set-completable`,
    {is_completable: isCompletable}
)

const deletePhase = (id) => axios.delete(`/api/phases/${id}`)

export { setPhaseCompletable, deletePhase }
