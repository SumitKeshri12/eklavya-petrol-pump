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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('user_id')->index()->nullable()->comment('user table id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('title', 100)->nullable()->comment('notification title');
            $table->longText('message')->nullable()->comment('notification message');
            $table->char('read_status', 1)->nullable()->comment('R => Read, U => Unread');
            $table->string('button_name', 20)->nullable()->comment('Button name which visible on Push Notification');
            $table->string('button_link', 500)->nullable()->comment('Button dynamic redirect url');
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
        Schema::dropIfExists('notifications');
    }
};
