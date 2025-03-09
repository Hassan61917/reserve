<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminAdsRequest;
use App\Http\Resources\v1\AdsResource;
use App\Models\Advertise;
use App\ModelServices\Ads\AdsService;
use Illuminate\Http\JsonResponse;

class AdminAdsController extends Controller
{
    protected string $resource = AdsResource::class;

    public function __construct(
        private AdsService $adsService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $ads = $this->adsService->getAdvertises()->withCount("orders");
        return $this->ok($this->paginate($ads));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminAdsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $ads = $this->adsService->makeAds($data);
        return $this->ok($ads);
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertise $ads): JsonResponse
    {
        $ads->load("orders")->loadCount("orders");
        return $this->ok($ads);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminAdsRequest $request, Advertise $ads): JsonResponse
    {
        $data = $request->validated();
        $ads->update($data);
        return $this->ok($ads);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertise $ads): JsonResponse
    {
        $ads->delete();
        return $this->deleted();
    }
}
