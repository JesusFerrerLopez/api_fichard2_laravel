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
        Schema::create('admin_times', function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('datetime')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('time_id')->index('time_id');
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_times');
    }
};
