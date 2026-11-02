<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permite guardar movimientos pagados por Stripe.
     */
    public function up(): void
    {
        if (! Schema::hasTable('cash_movements')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE cash_movements MODIFY payment_method ENUM('cash','card','stripe','transfer','other') NOT NULL DEFAULT 'cash'");
        }
    }

    /**
     * Vuelve a la lista anterior de metodos de pago.
     */
    public function down(): void
    {
        if (! Schema::hasTable('cash_movements')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE cash_movements MODIFY payment_method ENUM('cash','card','transfer','other') NOT NULL DEFAULT 'cash'");
        }
    }
};
