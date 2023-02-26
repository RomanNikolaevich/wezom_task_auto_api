<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\CarModelsService;
use Illuminate\Http\JsonResponse;

class CarModelsController extends Controller
{
    /**
     * @param int $makeId
     *
     * @return JsonResponse
     */
    public function updateModels(int $makeId):JsonResponse
    {
        return app(CarModelsService::class)->updateModels($makeId);
    }
}
