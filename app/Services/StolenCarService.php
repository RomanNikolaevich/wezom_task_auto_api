<?php

namespace App\Services;

use App\Exceptions\ApiResponseException;
use App\Http\Requests\StolenCarRequest;
use App\Models\StolenCar;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StolenCarService
{
    /**
     * @param $filters
     *
     * @return LengthAwarePaginator
     */
    public function indexFiltered($filters):LengthAwarePaginator
    {
        $query = StolenCar::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('number', 'LIKE', "%$search%")
                    ->orWhere('vin', 'LIKE', "%$search%");
            });
        }

        if (!empty($filters['make'])) {
            $query->where('make', $filters['make']);
        }

        if (!empty($filters['model'])) {
            $query->where('model', $filters['model']);
        }

        if (!empty($filters['model_year'])) {
            $query->where('model_year', $filters['model_year']);
        }

        if (!empty($filters['sort'])) {
            $sort = $filters['sort'];

            if ($sort[0] === '-') {
                $field = substr($sort, 1);
                $direction = 'desc';
            } else {
                $field = $sort;
                $direction = 'asc';
            }

            $query->orderBy($field, $direction);
        }

        return $query->paginate(10);
    }

    /**
     * @param StolenCar        $stolenCar
     * @param StolenCarRequest $request
     *
     * @return StolenCar
     * @throws ApiResponseException
     */
    public function store(array $request):StolenCar
    {
        $carInfo = $this->getCarInfo($request['vin']);

        $data = [
            'name'       => $request['name'],
            'number'     => $request['number'],
            'color'      => $request['color'],
            'vin'        => $request['vin'],
            'make'       => $carInfo['make'],
            'model'      => $carInfo['model'],
            'model_year' => $carInfo['model_year'],
        ];

        return StolenCar::create($data);
    }

    /**
     * @param string $vin
     *
     * @return StolenCar
     */
    public function findStolenCarByVin(string $vin):StolenCar
    {
        return StolenCar::where('vin', $vin)->first();
    }

    /**
     * @param StolenCar $stolenCar
     * @param array     $data
     *
     * @return StolenCar
     * @throws \Throwable
     */
    public function updateStolenCar(StolenCar $stolenCar, array $request):StolenCar
    {
        $stolenCar->updateOrFail($request);

        return $stolenCar;
    }

    /**
     * @param string $vin
     *
     * @return array
     * @throws ApiResponseException
     */
    private function getCarInfo(string $vin):array
    {
        $response = app(DataFromApiNhtsaService::class)->getCarInfo($vin);

        if (empty($response)) {
            throw new ApiResponseException('Failed to get Decode VIN', 404);
        }

        $make = $response['Results'][0]['Make'];
        $model = $response['Results'][0]['Model'];
        $modelYear = $response['Results'][0]['ModelYear'];

        return [
            'make'       => $make,
            'model'      => $model,
            'model_year' => $modelYear,
        ];
    }

}
