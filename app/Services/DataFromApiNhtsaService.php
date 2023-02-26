<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataFromApiNhtsaService
{
    /**
     * Get All Makes
     *
     * @return mixed
     */
    public function getMakes():mixed
    {
        $url = 'https://vpic.nhtsa.dot.gov/api/vehicles/getallmakes?format=json';

        return Http::get($url)->json();
    }

    /**
     * Get Models for MakeId
     *
     * @param int $makeId
     *
     * @return mixed
     */
    public function getModels(int $makeId):mixed
    {
        $url = 'https://vpic.nhtsa.dot.gov/api/vehicles/getmodelsformakeid/'.$makeId.'?format=json';

        return Http::get($url)->json();
    }

    /**
     * Decode VIN (flat format)
     *
     * @param string $vin
     *
     * @return mixed
     */
    public function getCarInfo(string $vin):mixed
    {
        $url = 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinvalues/'.$vin.'?format=json';

        return Http::get($url)->json();
    }

}
