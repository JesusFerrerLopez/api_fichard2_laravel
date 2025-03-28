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
            $table->id();

            // Columna con fecha y hora
            $table->timestamp('datetime');

            // Columna con hora
            $table->time('time');

            // Columna con fecha
            $table->date('date');

            // Columna con tipo en función de la acción del usuario
            $table->enum('type', ['play', 'pause', 'stop']);

            // Columna con descripción de la pausa, nullable
            $table->string('pause_reason')->nullable();

            // Estos campos no tienen utilidad todavía, son nulos 
            /*
            "generated": null,
            "device": null,
            "longitude": null,
            "latitude": null,
            */
            $table->string('generated')->nullable();
            $table->string('device')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();

            // User ID, deberia ser una foreign key pero de momento solo un int
            $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreignId('user_id')->constrained();

            // Columna con fecha de borrado
            $table->timestamp('deleted_at')->nullable();
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
