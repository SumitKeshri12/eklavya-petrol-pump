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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unique()->index()->comment('AUTO_INCREMENT');

            $table->unsignedInteger('role_id')->nullable()->comment('Roles table id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('user_code', 10)->index()->nullable()->comment('random or incremental value for DSM mainly use for DSM login');
            $table->char('user_type', 1)->index()->nullable()->comment('D => DSM, A => Admin, P => Party');
            $table->char('party_type', 1)->nullable()->comment('I => Individual, B => Business');
            $table->string('first_name', 50)->nullable()->comment('first name of user');
            $table->string('last_name', 50)->nullable()->comment('last name if user');
            $table->string('party_name', 100)->nullable()->comment('party name');
            $table->string('email', 320)->nullable()->comment('email of user or party');
            $table->string('mobile_number', 15)->index()->nullable()->comment('number of user or party');
            $table->string('password', 255)->nullable();
            $table->binary('aadhar_no', 1000)->nullable()->comment('encryption');
            $table->binary('esic_number', 1000)->nullable()->comment('encryption');
            $table->binary('pancard', 1000)->nullable()->comment('encryption');
            $table->string('profile', 500)->nullable();
            $table->binary('bank_name', 1000)->nullable()->comment('encryption');
            $table->string('account_number', 20)->nullable()->comment('encryption');
            $table->string('ifsc_code', 11)->nullable()->comment('encryption');
            $table->string('account_holder_name', 100)->nullable()->comment('encryption');
            $table->string('gstin', 15)->nullable()->comment('encryption');
            $table->string('tan_number', 10)->nullable()->comment('encryption');
            $table->char('status', 1)->index()->nullable()->default('Y')->comment('Y => Active, N => Inactive');
            $table->timestamp('last_login_at')->nullable()->comment('last login date-time');
            $table->char('locale', 6)->index()->nullable()->default('en');
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
        Schema::dropIfExists('users');
    }
};
