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
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('shift_id')->index()->nullable()->comment('shift tbl id');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->string('vehicle_number', 15)->index()->nullable()->comment('vehicle number (GJ05AX1234)');

            $table->unsignedInteger('user_id')->index()->nullable()->comment('user table party id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('with_vehicle', 1)->nullable()->comment('W => With Vehicle, O => Without Vehicle');
            $table->string('mobile_number', 15)->nullable()->comment('contact number');
            $table->char('fuel_type', 1)->nullable()->comment('P => Petrol, D => Diesel');
            $table->char('payment_type', 1)->nullable()->comment('O => Online, X => Others, C => Credit');
            $table->char('payment_method', 1)->nullable()->comment('C => Credit Card, U => UPI, D => Debit Card');
            $table->integer('volume_liters')->nullable()->comment('dispense volumn in liters');
            $table->integer('amount')->nullable()->comment('dispense amount behalf of petrol/diesel');
            $table->integer('count')->nullable()->comment('Total Cash Note');
            $table->string('remark', 300)->nullable()->comment('Any Remark');
            $table->char('status', 1)->nullable()->comment('F => Fail, S => Success');
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
        Schema::dropIfExists('transactions');
    }
};
