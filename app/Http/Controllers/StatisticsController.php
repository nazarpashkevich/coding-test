<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class StatisticsController extends Controller
{

    public function __construct(protected StatisticService $service)
    {
    }

    public function index(): View
    {
       return view('statistics.index');
    }

    public function usersWithCountTasks(): JsonResponse
    {
       return new JsonResponse($this->service->getUsersWithCountTasks());
    }

    public function weekCompletedTasksCount(): JsonResponse
    {
       return new JsonResponse(['count' => $this->service->getWeekCompletedTasksCount()]);
    }

    public function monthCompletedTasksCount(): JsonResponse
    {
       return new JsonResponse(['count' => $this->service->getMonthCompletedTasksCount()]);
    }
}
