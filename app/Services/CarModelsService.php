<?php

namespace App\Services;

use App\Models\CarModel;
use Illuminate\Http\JsonResponse;

class CarModelsService
{
    /**
     * @param int $makeId
     *
     * @return JsonResponse
     */
    public function updateModels(int $makeId):JsonResponse
    {
        $response = app(DataFromApiNhtsaService::class)->getModels($makeId);

        if (!$response) {
            return response()->json(['message' => 'Failed to get Models'], 404);
        }

        foreach ($response['Results'] as $result) {
            CarModel::updateOrCreate([
                'model_id' => $result['Model_ID'],
            ], [
                'make_id'    => $makeId,
                'model_name' => $result['Model_Name'],
            ]);
        }

        return response()->json(['message' => 'Models updated successfully']);
    }
}
