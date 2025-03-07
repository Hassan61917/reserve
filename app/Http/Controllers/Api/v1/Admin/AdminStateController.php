<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminStateRequest;
use App\Http\Resources\v1\StateResource;
use App\Models\State;
use App\ModelServices\Location\LocationService;
use Illuminate\Http\JsonResponse;

class AdminStateController extends Controller
{
    protected string $resource = StateResource::class;

    public function __construct(
        private LocationService $locationService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $states = $this->locationService->getStates()->withCount("cities");
        return $this->ok($this->paginate($states));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminStateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $state = $this->locationService->makeState($data);
        return $this->ok($state);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state): JsonResponse
    {
        $state->load('cities')->loadCount("cities");
        return $this->ok($state);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminStateRequest $request, State $state): JsonResponse
    {
        $data = $request->validated();
        $state->update($data);
        return $this->ok($state);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state): JsonResponse
    {
        $state->delete();
        return $this->deleted();
    }
}
