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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->integer('price')->nullable();
            $table->integer('users')->nullable();
            $table->integer('times')->nullable();
            $table->text('description');
            $table->string('type')->default('custom');
            $table->text('confirm_msg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
