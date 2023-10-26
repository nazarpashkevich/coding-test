<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetPhaseCompletableRequest;
use App\Http\Requests\StorePhaseRequest;
use App\Http\Requests\UpdatePhaseRequest;
use App\Models\Phase;
use App\Services\PhaseService;
use Illuminate\Http\JsonResponse;

class PhaseController extends Controller
{
    public function __construct(protected PhaseService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Phase $phase)
    {
        return $phase->load('tasks.user')->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        //
    }


    public function setCompletable(Phase $phase, SetPhaseCompletableRequest $request): JsonResponse
    {
        $this->service->setCompletable($phase, $request->isCompletable());

        return new JsonResponse(['status' => 'success']);
    }
}
