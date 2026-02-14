<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rca_reports', function (Blueprint $table) {
            $table->id();
            $table->string('likely_cause')->nullable();
            $table->float('confidence')->nullable();
            $table->text('next_steps')->nullable();
            $table->json('raw_logs')->nullable();
            $table->json('metrics')->nullable();
            $table->string('report_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rca_reports');
    }
};
