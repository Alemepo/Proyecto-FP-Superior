<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de movimientos de caja.
     *
     * Cada movimiento es un ingreso o una salida:
     * - pago de suscripción
     * - venta de agua
     * - venta manual
     * - retirada de dinero
     * - ajuste
     */
    public function up(): void
    {
        Schema::create('cash_movements', function (Blueprint $table) {
            $table->id();

            // Caja diaria a la que pertenece este movimiento.
            $table->foreignId('cash_closure_id')
                ->constrained('cash_closures')
                ->cascadeOnDelete();

            // Usuario cliente relacionado con el movimiento.
            // Puede ser null si es una venta manual, por ejemplo "agua".
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Admin que registra el movimiento.
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Tipo de movimiento.
            // income = entra dinero
            // expense = sale dinero
            $table->enum('type', ['income', 'expense']);

            // Categoría del movimiento.
            // subscription: pago de plan
            // product: producto tipo agua, barrita, etc.
            // manual: ingreso manual
            // withdrawal: retirada
            // adjustment: ajuste de caja
            $table->enum('category', [
                'subscription',
                'product',
                'manual',
                'withdrawal',
                'adjustment'
            ])->default('manual');

            // Método de pago.
            $table->enum('payment_method', [
                'cash',
                'card',
                'stripe',
                'transfer',
                'other'
            ])->default('cash');

            // Descripción visible en la caja.
            // Ejemplo: "Agua", "Suscripción mensual", "Retirada para cambio".
            $table->string('description');

            // Importe positivo.
            // El campo type indica si suma o resta.
            $table->decimal('amount', 10, 2);

            // Observaciones opcionales.
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla si hacemos rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_movements');
    }
};
