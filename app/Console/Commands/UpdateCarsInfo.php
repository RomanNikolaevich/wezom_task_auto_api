<?php

namespace App\Console\Commands;

use App\Services\CarMakesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCarsInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateCarsInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update the base of makes and models of cars';

    /**
     * Execute the console command.
     * Clear the cache for all car models
     */
    public function handle(): void
    {
        app(CarMakesService::class)->updateMakes();

        Cache::forget('car_models_*');


    }
}
