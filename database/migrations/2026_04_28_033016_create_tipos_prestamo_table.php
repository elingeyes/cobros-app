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
        Schema::create('tipos_prestamo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('interes', 5, 2)->comment('Porcentaje de interés');
            $table->integer('plazo')->comment('Plazo en meses');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_prestamo');
    }
};
