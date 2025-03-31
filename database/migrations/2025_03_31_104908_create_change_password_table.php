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
        Schema::create('change_password', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('company_id');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('new_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_password');
    }
};
