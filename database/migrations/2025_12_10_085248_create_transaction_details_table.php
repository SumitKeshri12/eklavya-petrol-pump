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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('transaction_id')->index()->nullable()->comment('transaction tbl id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->integer('1_rupee')->nullable()->comment('1 rs count');
            $table->integer('2_rupee')->nullable()->comment('2 rs count');
            $table->integer('5_rupee')->nullable()->comment('5 rs count');
            $table->integer('10_rupee')->nullable()->comment('10 rs count');
            $table->integer('20_rupee')->nullable()->comment('20 rs count');
            $table->integer('50_rupee')->nullable()->comment('50 rs count');
            $table->integer('100_rupee')->nullable()->comment('100 rs count');
            $table->integer('200_rupee')->nullable()->comment('200 rs count');
            $table->integer('500_rupee')->nullable()->comment('500 rs count');
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
        Schema::dropIfExists('transaction_details');
    }
};
