<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de cajas diarias.
     *
     * Cada registro representa una caja de un día concreto.
     * Ejemplo: caja del 01/05/2026.
     */
    public function up(): void
    {
        Schema::create('cash_closures', function (Blueprint $table) {
            $table->id();

            // Fecha de la caja. Usamos unique para que solo exista una caja por día.
            $table->date('cash_date')->unique();

            // Dinero con el que se abre la caja al inicio del día.
            $table->decimal('opening_amount', 10, 2)->default(0);

            // Dinero real contado al cerrar caja.
            // Lo dejamos nullable porque mientras la caja está abierta todavía no se ha cerrado.
            $table->decimal('closing_amount', 10, 2)->nullable();

            // Estado de la caja: abierta o cerrada.
            $table->enum('status', ['open', 'closed'])->default('open');

            // Usuario admin que abrió la caja.
            $table->foreignId('opened_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Usuario admin que cerró la caja.
            $table->foreignId('closed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Fecha y hora exacta de cierre.
            $table->timestamp('closed_at')->nullable();

            // Observaciones generales del cierre.
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla si hacemos rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_closures');
    }
};