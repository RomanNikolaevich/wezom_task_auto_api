<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Http\JsonResponse;

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

        $carModels = CarModel::where('make_id', $carMake->make_id)->get(['model_name']);

        if ($carModels->isEmpty()) {
            return response()->json(['message' => 'No car models found']);
        }

        return response()->json(['car_models' => $carModels]);
    }

}
