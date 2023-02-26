<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StolenCarRequest;
use App\Models\StolenCar;
use App\Services\StolenCarExportService;
use App\Services\StolenCarService;
use Illuminate\Http\JsonResponse;

class StolenCarController extends Controller
{
    protected StolenCarService $stolenCarService;

    public function __construct(StolenCarService $stolenCarService)
    {
        $this->stolenCarService = $stolenCarService;
    }

    /**
     * used to get a list of all cars that have been stolen;
     *
     * @return JsonResponse
     */
    public function index():JsonResponse
    {
        $stolenCars = StolenCar::all();

        if ($stolenCars->isEmpty()) {
            return response()->json(['message' => 'No stolen cars found.'], 404);
        }

        return response()->json([
            'data' => $stolenCars,
        ]);
    }

    /**
     * used to get a list of filtered cars that have been stolen;
     *
     * @param StolenCarRequest $request
     *
     * @return JsonResponse
     */
    public function indexFiltered(StolenCarRequest $request):JsonResponse
    {
        $stolenCars = $this->stolenCarService->indexFiltered($request->all());

        if ($stolenCars->isEmpty()) {
            return response()->json(['message' => 'No filtered stolen cars found.'], 404);
        }

        if ($request->has('export')) {
            return app(StolenCarExportService::class)->writeFiltered($request);
        }

        return response()->json($stolenCars);
    }

    /**
     * used to add a new car that has been stolen;
     *
     * @param StolenCarRequest $request
     *
     * @return JsonResponse
     */
    public function store(StolenCarRequest $request):JsonResponse
    {
        $stolenCar = $this->stolenCarService->store($request->validated());

        return response()->json([
            'message' => 'Stolen car added successfully',
            'data'    => $stolenCar,
        ], 201);
    }

    /**
     * used to update information about a stolen vehicle;
     *
     * @param StolenCarRequest $request
     * @param string           $vin
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(StolenCarRequest $request, string $vin):JsonResponse
    {
        $stolenCar = $this->stolenCarService->findStolenCarByVin($vin);

        if (empty($stolenCar)) {
            return response()->json([
                'message' => 'Vin code stolen car not found',
            ], 404);
        }

        $updatedStolenCar = $this->stolenCarService->updateStolenCar($stolenCar, $request->validated());

        return response()->json([
            'message' => 'Stolen car updated successfully',
            'data'    => $updatedStolenCar,
        ], 202);
    }

    /**
     * used to remove a stolen vehicle from the database.
     *
     * @param string $vin
     *
     * @return JsonResponse
     */
    public function destroy(string $vin):JsonResponse
    {
        if (empty($vin)) {
            return response()->json([
                'message' => 'Vin code was not received',
            ], 404);
        }
        $stolenCar = $this->stolenCarService->findStolenCarByVin($vin);
        $stolenCar->delete();

        return response()->json([
            'message' => 'Stolen car deleted successfully',
        ], 204);
    }

}
