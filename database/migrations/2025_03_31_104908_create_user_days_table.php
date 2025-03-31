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
        Schema::create('user_days', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('user_id');
            $table->string('data', 9999);
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('type')->default('interval');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_days');
    }
};
