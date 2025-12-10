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
        Schema::create('party_details', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('user_id')->index()->nullable()->comment('Users table id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('owner_name_1', 50)->nullable()->comment('owner 1 name');
            $table->string('owner_1_mobile', 15)->nullable()->comment('owner 1 mobile');
            $table->string('owner_name_2', 50)->nullable()->comment('owner 2 name');
            $table->string('owner_2_mobile', 15)->nullable()->comment('owner 2 mobile');
            $table->string('owner_name_3', 50)->nullable()->comment('owner 3 name');
            $table->string('owner_3_mobile', 15)->nullable()->comment('owner 3 mobile');
            $table->string('manager_name', 50)->nullable()->comment('manager name');
            $table->string('manager_mobile', 15)->nullable()->comment('manager mobile');
            $table->string('contact_name', 50)->nullable()->comment('contact name');
            $table->string('contact_mobile', 15)->nullable()->comment('contact mobile');
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
        Schema::dropIfExists('party_details');
    }
};
