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
        Schema::create('demands', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('user_id')->index()->nullable()->comment('user table party id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('fuel_type', 1)->nullable()->comment('P => Petrol, D => Diesel');
            $table->date('demand_date')->nullable()->comment('date of demand');
            $table->char('with_vehicle', 1)->nullable()->comment('W => With Vehicle, O => Without Vehicle');
            $table->string('vehicle_number', 15)->index()->nullable()->comment('vehicle number (GJ05AX1234)');
            $table->string('receiver_mobile_no', 15)->nullable()->comment('without vehicle receiver mobile number');
            $table->decimal('fuel_quantity', 13, 2)->nullable()->comment('request fuel quantity');
            $table->decimal('quantity_fullfill', 13, 2)->nullable()->comment('fullfill fuel quantity');
            $table->decimal('outstanding_quantity', 13, 2)->nullable()->comment('pending fuel quantity');
            $table->char('status', 1)->nullable()->comment('P => Pending, C => Completed, R => Rejected, A => Active, I => Inactive');

            $table->unsignedInteger('shift_id')->nullable()->comment('shift tbl id');
            $table->foreign('shift_id')->references('id')->on('shifts');

            $table->unsignedInteger('nozzle_id')->nullable()->comment('store nozzle id');
            $table->foreign('nozzle_id')->references('id')->on('dispenser_nozzles');
            $table->string('receipt_image', 500)->nullable();
            $table->string('product_image', 500)->nullable();
            $table->string('driver_image', 500)->nullable();
            $table->string('vehicle_image', 500)->nullable();
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
        Schema::dropIfExists('demands');
    }
};
