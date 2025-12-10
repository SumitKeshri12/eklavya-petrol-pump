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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');
            $table->string('name', 50)->unique()->index()->nullable()->comment('product name');
            $table->string('chr_code', 20)->unique()->nullable()->comment('chr code');
            $table->string('hsn_code', 8)->nullable()->comment('hsn code');
            $table->string('category', 50)->index()->nullable()->comment('Fixed product category');
            $table->char('unit', 2)->nullable()->default('LI')->comment('LI => Liter,ML => Milliliter,GA => Gallon,PT => Pint,QT => Quart,CU => Cup, QT => QTY');
            $table->decimal('tax_rate', 5, 2)->nullable()->comment('tax rate');
            $table->decimal('cess', 5, 2)->nullable()->comment('cess');
            $table->decimal('opening_quantity', 13, 2)->nullable()->comment('open quantity');
            $table->decimal('opening_rate', 13, 2)->nullable()->comment('opening rate');
            $table->decimal('purchase_rate', 13, 2)->nullable()->comment('purchase rate');
            $table->decimal('opening_value', 13, 2)->nullable()->comment('open value');
            $table->decimal('selling_rate', 13, 2)->nullable()->comment('sell rate');
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
        Schema::dropIfExists('products');
    }
};
