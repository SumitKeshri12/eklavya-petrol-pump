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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('user_id')->index()->nullable()->comment('Users table id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('vehicle_number', 15)->index()->nullable()->comment('vehicle number (GJ05AX1234)');
            $table->char('fuel_type', 1)->nullable()->comment('P => Petrol, D => Diesel');
            $table->char('status', 1)->nullable()->default('Y')->comment('Y => Active, N => InActive');
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
        Schema::dropIfExists('vehicles');
    }
};
