
const setPhaseCompletable = (id, isCompletable) => axios.put(
    `/api/phases/${id}/set-completable`,
    {is_completable: isCompletable}
)

export { setPhaseCompletable }
