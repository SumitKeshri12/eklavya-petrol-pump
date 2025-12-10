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
        Schema::create('demand_products', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('demand_id')->index()->nullable()->comment('demands tbl id');
            $table->foreign('demand_id')->references('id')->on('demands');

            $table->unsignedInteger('product_id')->nullable()->comment('product tbl id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('quantity', 13, 2)->nullable()->comment('product quantity');
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
        Schema::dropIfExists('demand_products');
    }
};
