<?php
namespace App\Services;

use App\Models\Phase;

class PhaseService
{

    public function setCompletable(Phase $phase, bool $isCompletable): void
    {
        $phase->loadMissing('tasks');

        $phase->is_completable = $isCompletable;
        if ($isCompletable) {
            $phase->tasks()->whereNull('completed_at')->update(['completed_at' => now()]);
        }

        $phase->save();
    }
}
