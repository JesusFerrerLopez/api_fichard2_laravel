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
        // Creación de la tabla de usuarios.
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            // Código de usuario varchar(10) debería ser único, pero los datos de prueba están repetidos
            $table->string('code', 64);

            // Rol de usuario, por defecto 'user'
            $table->enum('rol', ['admin', 'user'])->default('user');

            // Campos sin utilidad todavía, time_start y time_end
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();

            // Tabla de status, enabled o disabled. Por defecto enabled
            $table->enum('status', ['enabled', 'disabled'])->default('enabled');

            // Timestamps
            $table->timestamps();

            // company_id todavía no se usa, será una foreign key pero de momento solo un int
            $table->unsignedBigInteger('company_id')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
