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
        Schema::create('sanctions', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('user_id')->nullable()->comment('user table party id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('month', 2)->nullable()->comment('senction month');
            $table->year('year')->nullable()->comment('senction year');
            $table->char('fuel_type', 1)->nullable()->comment('P => Petrol, D => Diesel');
            $table->decimal('quantity', 13, 2)->nullable()->comment('approve quantity');
            $table->text('remarks')->nullable()->comment('any remark by admin');
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
        Schema::dropIfExists('sanctions');
    }
};
