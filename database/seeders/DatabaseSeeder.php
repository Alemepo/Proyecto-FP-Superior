<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
         * Creamos el usuario de prueba solo si no existe.
         * Así podemos ejecutar php artisan db:seed varias veces
         * sin que falle por email duplicado.
         */
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        /*
         * Seeder de rutinas predeterminadas.
         */
        $this->call(RoutineSeeder::class);
    }
}