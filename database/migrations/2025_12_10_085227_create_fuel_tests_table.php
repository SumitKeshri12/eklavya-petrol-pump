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
        Schema::create('fuel_tests', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('shift_id')->nullable()->comment('shifts tbl id');
            $table->foreign('shift_id')->references('id')->on('shifts');

            $table->unsignedInteger('shift_nozzle_reading_id')->nullable()->comment('shift nozzles tbl id');
            $table->foreign('shift_nozzle_reading_id')->references('id')->on('shift_nozzle_readings');
            $table->decimal('test_reading_start', 13, 2)->nullable()->comment('test reading start');
            $table->decimal('test_reading_end', 13, 2)->nullable()->comment('test reading end');
            $table->decimal('test_reading_liters', 13, 2)->nullable()->comment('testign liters');
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
        Schema::dropIfExists('fuel_tests');
    }
};
