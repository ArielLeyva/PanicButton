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
            $table->foreignId('button_id')
                ->nullable()
                ->default(null)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('name', 80);
            $table->string('dni', 20);
            $table->string('email');
            $table->enum('gender', ['Femenino', 'Masculino']);
            $table->text('details');
            $table->date('birthdate');
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
