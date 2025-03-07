<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminCityRequest;
use App\Http\Resources\v1\CityResource;
use App\Models\City;
use App\ModelServices\Location\LocationService;
use Illuminate\Http\JsonResponse;

class AdminCityController extends Controller
{
    protected string $resource = CityResource::class;

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
        $cities = $this->locationService->getCities(["state"]);
        return $this->ok($this->paginate($cities));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCityRequest $request): JsonResponse
    {
        $data = $request->validated();
        $city = $this->locationService->makeCity($data);
        return $this->ok($city);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city): JsonResponse
    {
        $city->load('state');
        return $this->ok($city);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCityRequest $request, City $city): JsonResponse
    {
        $data = $request->validated();
        $city->update($data);
        return $this->ok($city);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city): JsonResponse
    {
        $city->delete();
        return $this->deleted();
    }
}
