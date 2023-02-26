<?php

namespace App\Services;

use App\Http\Controllers\API\V1\CarModelsController;
use App\Models\CarMake;
use Illuminate\Http\JsonResponse;

class CarMakesService
{
    /**
     * @return JsonResponse
     */
    public function updateMakes():JsonResponse
    {
        $response = app(DataFromApiNhtsaService::class)->getMakes();

        if (!$response) {
            return response()->json(['message' => 'Failed to get Makes'], 404);
        }

        foreach ($response['Results'] as $result) {
            CarMake::updateOrCreate([
                'make_id' => $result['Make_ID'],
            ], [
                'make_name' => $result['Make_Name'],
            ]);

            app(CarModelsController::class)->updateModels($result['Make_ID']);
        }

        return response()->json(['message' => 'Makes updated successfully']);
    }

}
