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
        Schema::create('user_days_hours', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('data');
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_days_hours');
    }
};
