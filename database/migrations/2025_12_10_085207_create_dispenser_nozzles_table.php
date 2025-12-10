<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dispenser_nozzles', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('dispenser_id')->index()->nullable()->comment('dispenser tbl id');
            $table->foreign('dispenser_id')->references('id')->on('dispensers');
            $table->string('nozzle_number', 20)->index()->nullable()->comment('nozzle number');
            $table->char('fuel_type', 1)->nullable()->comment('P => Petrol, D => Diesel');
            $table->char('status', 1)->nullable()->comment('Y => Active, N => InActive');
            $table->unsignedInteger('created_by')->nullable()->comment('');
            $table->unsignedInteger('updated_by')->nullable()->comment('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('dispenser_nozzles');
    }
};
