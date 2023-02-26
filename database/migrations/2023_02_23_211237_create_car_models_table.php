<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up():void
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->integer('make_id')->index();
            $table->integer('model_id')->unique();
            $table->string('model_name');


            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('car_models');
    }
};
