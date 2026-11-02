<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ej: Crossfit, Yoga
            $table->text('description')->nullable();
            $table->dateTime('start_time'); // Inicio de la clase
            $table->dateTime('end_time'); // Fin de la clase
            $table->integer('capacity'); // Control de aforo de cada clase
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
