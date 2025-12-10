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
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('shift_id')->index()->nullable()->comment('shift tbl id');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->integer('nozzle_id')->index()->nullable()->comment('store nozzle id');
            $table->date('date')->index()->nullable()->comment('sales date');
            $table->decimal('test_ltr', 13, 2)->nullable()->comment('this date testing liters');
            $table->decimal('cash_collected', 13, 2)->nullable()->comment('cash payment collection');
            $table->decimal('online_collected', 13, 2)->nullable()->comment('online payment collection');
            $table->decimal('credit_sales', 13, 2)->nullable()->comment('demand fulfill sales');
            $table->decimal('petrol_consumed', 13, 2)->nullable()->comment('sale petrol in liters');
            $table->decimal('diesel_consumed', 13, 2)->nullable()->comment('sale diesel in liters');
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
        Schema::dropIfExists('sales');
    }
};
