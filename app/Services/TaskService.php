<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{

    public function update(Task $task, array $toUpdate): void
    {
        $task->fill($toUpdate);

        $task->load('phase');

        if ($task->phase->is_completable && !$task->completed_at) {
            $task->completed_at = now();
        }

        $task->save();
    }
}
