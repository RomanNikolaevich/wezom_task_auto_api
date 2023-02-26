<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up():void
    {
        Schema::create('stolen_cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number')->unique();
            $table->string('color');
            $table->string('vin')->unique();
            $table->string('make');
            $table->string('model');
            $table->integer('model_year');
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('stolen_cars');
    }
};
