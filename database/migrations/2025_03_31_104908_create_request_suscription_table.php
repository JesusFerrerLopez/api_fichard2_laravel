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
        Schema::create('request_suscription', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('subscription_id');
            $table->text('name');
            $table->text('cif');
            $table->text('city')->nullable();
            $table->text('address');
            $table->string('email');
            $table->integer('phone');
            $table->string('person');
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_suscription');
    }
};
