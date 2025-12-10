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
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');
            $table->string('name', 100)->index()->nullable()->comment('org name');
            $table->string('owner_name', 100)->index()->nullable()->comment('owner name');
            $table->string('contact_number', 15)->nullable()->comment('contact number');
            $table->string('email', 100)->nullable()->comment('org or owner email');
            $table->string('address', 255)->nullable()->comment('address');
            $table->string('state', 50)->nullable()->comment('state define in config file');
            $table->string('city', 50)->nullable()->comment('city define in config file');
            $table->string('pincode', 6)->nullable()->comment('pincode');
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
        Schema::dropIfExists('organizations');
    }
};
