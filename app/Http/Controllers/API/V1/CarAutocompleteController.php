<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CarAutocompleteController extends Controller
{

    /**
     * Search for cars by make name
     *
     * @param string $makeName
     *
     * @return JsonResponse
     */
    public function searchByMakeName(string $makeName):JsonResponse
    {
        $carMake = CarMake::where('make_name', 'LIKE', '%'.$makeName.'%')->first();

        if (!$carMake) {
            return response()->json(['message' => 'Car make not found'], 404);
        }

        // Generate a cache key based on the make ID
        $cacheKey = 'car_models_'.$carMake->make_id;

        // Try to get the data from cache
        $carModels = Cache::get($cacheKey);

        if (!$carModels) {
            // If the data is not in cache, fetch it from the database
            $carModels = CarModel::where('make_id', $carMake->make_id)->get(['model_name']);

            // Cache the data for one month
            Cache::put($cacheKey, $carModels, now()->addMonth());
        }


        if ($carModels->isEmpty()) {
            return response()->json(['message' => 'No car models found']);
        }

        return response()->json(['car_models' => $carModels]);
    }

}
