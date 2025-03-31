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
        Schema::create('companies', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name');
            $table->string('email');
            $table->integer('tlf')->nullable();
            $table->string('username');
            $table->string('type')->default('demo');
            $table->text('notes')->nullable();
            $table->integer('notif_incidence')->nullable()->default(0);
            $table->string('email_notif')->nullable();
            $table->string('password');
            $table->integer('subscription_id')->default(0);
            $table->integer('empleados')->nullable();
            $table->string('device')->nullable();
            $table->text('os')->nullable();
            $table->string('limite_informes')->nullable();
            $table->string('token_access')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->string('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
