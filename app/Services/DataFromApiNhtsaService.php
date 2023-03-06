<?php

namespace App\Services;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;

class DataFromApiNhtsaService
{
    /**
     * @var Repository|Application|mixed
     */
    private mixed $link;
    /**
     * @var Repository|Application|mixed
     */
    private mixed $format;

    public function __construct()
    {
        $this->link = config('link.api_url');
        $this->format = config('link.format');
    }

    /**
     * Get All Makes
     *
     * @return mixed
     */
    public function getMakes():mixed
    {
        $url = $this->link.'getallmakes'.$this->format;

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
        $url = $this->link.'getmodelsformakeid/'.$makeId.$this->format;

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
        $url = $this->link.'decodevinvalues/'.$vin.$this->format;

        return Http::get($url)->json();
    }

}
