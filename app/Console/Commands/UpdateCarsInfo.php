<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\V1\CarMakesController;
use App\Http\Controllers\API\V1\CarModelsController;
use Illuminate\Console\Command;

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
     */
    public function handle(): void
    {
        app(CarMakesController::class)->updateMakes();

    }
}
