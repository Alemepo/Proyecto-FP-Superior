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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('id_type', ['DNI', 'NIE', 'Pasaporte'])->nullable();
            $table->string('id_number')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->date('registration_date')->nullable();
            $table->text('address')->nullable();
            $table->string('country')->nullable();
            $table->string('locality')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->boolean('rgpd_consent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'id_type',
                'id_number',
                'phone',
                'birthdate',
                'gender',
                'registration_date',
                'address',
                'country',
                'locality',
                'province',
                'postal_code',
                'emergency_contact',
                'rgpd_consent',
            ]);
        });
    }
};
