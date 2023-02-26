<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\CarMakesService;
use Illuminate\Http\JsonResponse;

class CarMakesController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function updateMakes():JsonResponse
    {
        return app(CarMakesService::class)->updateMakes();
    }
}
