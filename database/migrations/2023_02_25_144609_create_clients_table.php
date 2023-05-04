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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('email', )->unique();
            $table->string('password');
            $table->string('name', 80);
            $table->string('avatar', 60)->nullable()->default(null);
            $table->string('dni', 20);
            $table->enum('gender', ['Femenino', 'Masculino']);
            $table->foreignId('address_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->enum('state', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
