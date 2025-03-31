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
        Schema::create('times', function (Blueprint $table) {
            $table->integer('id', true);
            $table->dateTime('datetime');
            $table->time('time');
            $table->date('date');
            $table->string('type', 11);
            $table->string('pause_reason')->nullable();
            $table->integer('generated')->nullable();
            $table->string('device')->nullable();
            $table->text('longitude')->nullable();
            $table->text('latitude')->nullable();
            $table->integer('user_id')->index('user_id');
            $table->integer('centro_coste_id')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('times');
    }
};
