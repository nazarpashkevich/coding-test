<?php
namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class StatisticService
{

    public function getUsersWithCountTasks(): Collection
    {
        return User::query()->withCount('tasks')->get();
    }

    public function getWeekCompletedTasksCount(): int
    {
        $now = CarbonImmutable::now();
        return Task::query()->whereBetween('completed_at', [$now->startOfWeek(), $now->endOfWeek()])->count();
    }

    public function getMonthCompletedTasksCount(): int
    {
        $now = CarbonImmutable::now();
        return Task::query()->whereBetween('completed_at', [$now->startOfMonth(), $now->endOfMonth()])->count();
    }
}
