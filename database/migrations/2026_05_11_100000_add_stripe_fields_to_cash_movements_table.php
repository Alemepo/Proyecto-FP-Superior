<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega campos de Stripe a la tabla de movimientos de caja.
     */
    public function up(): void
    {
        Schema::table('cash_movements', function (Blueprint $table) {
            // ID único de la transacción en Stripe
            $table->string('stripe_payment_id')->nullable()->unique()->after('notes');
            
            // Estado del pago en Stripe (succeeded, pending, failed)
            $table->string('stripe_status')->nullable()->after('stripe_payment_id');
            
            // Información adicional de Stripe en JSON
            $table->json('stripe_metadata')->nullable()->after('stripe_status');
        });
    }

    /**
     * Revierte los cambios.
     */
    public function down(): void
    {
        if (Schema::hasIndex('cash_movements', ['stripe_payment_id'], 'unique')) {
            Schema::table('cash_movements', function (Blueprint $table) {
                $table->dropUnique(['stripe_payment_id']);
            });
        }

        Schema::table('cash_movements', function (Blueprint $table) {
            $table->dropColumn(['stripe_payment_id', 'stripe_status', 'stripe_metadata']);
        });
    }
};
