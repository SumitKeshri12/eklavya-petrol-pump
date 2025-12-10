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
        Schema::create('jsm_api_logs', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');
            $table->text('auth_token')->nullable()->comment('Auth Token That we are passing to API request');
            $table->string('ip_address', 50)->nullable()->comment('IP Address of the user');
            $table->string('api_url', 300)->nullable()->comment('API URL');
            $table->text('request_data')->nullable()->comment('Request that are passing to API');
            $table->char('is_response_success', 1)->nullable()->comment('S => Success, F => Fail. Is response getting success or not');
            $table->longText('response_data')->nullable()->comment('Response that we are sending to API');
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
        Schema::dropIfExists('jsm_api_logs');
    }
};
