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
        Schema::create('push_notification_templates', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');
            $table->string('type', 100)->nullable()->comment('Push notification type');
            $table->string('label', 100)->nullable()->comment('Menu display name');
            $table->string('title', 500)->nullable()->comment('Title of Push Notification');
            $table->longText('body')->nullable()->comment('Body of Push Notification');
            $table->string('image', 500)->nullable()->comment('Image path and filename');
            $table->string('button_name', 20)->nullable()->comment('Button name which visible on Push Notification');
            $table->string('button_link', 500)->nullable()->comment('Button dynamic redirect url');
            $table->char('status', 1)->nullable()->default('Y')->comment('I=>Inactive, A=>Active');
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
        Schema::dropIfExists('push_notification_templates');
    }
};
