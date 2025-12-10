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
        Schema::create('shift_nozzle_readings', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('shift_id')->nullable()->comment('shifts tbl id');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->string('nozzle_number', 20)->nullable()->comment('store nozzle id number');
            $table->decimal('start_reading', 13, 2)->nullable()->comment('shift start reading');
            $table->decimal('end_reading', 13, 2)->nullable()->comment('end shift reading');
            $table->decimal('total_dispensed', 13, 2)->nullable()->comment('details of dispense petrol/diesel');
            $table->decimal('total_amount', 13, 2)->nullable()->comment('dispense petrol/diesel amount');
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
        Schema::dropIfExists('shift_nozzle_readings');
    }
};
