<x-app-layout>
    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">
            <div style="max-width: 600px; margin: 0 auto; text-align: center;">

                <!-- Icono de información -->
                <div style="margin-bottom: 30px;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; background-color: #f59e0b; border-radius: 50%;">
                        <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Título -->
                <h1 style="color: #f59e0b; font-size: 36px; font-weight: bold; margin-bottom: 10px;">PAGO PENDIENTE</h1>
                <p style="color: #888; font-size: 16px; margin-bottom: 40px;">Tu pago está en proceso</p>

                <!-- Mensaje -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                    <p style="color: #ccc; font-size: 16px; margin-bottom: 20px;">
                        {{ $message }}
                    </p>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #333;">
                        <p style="color: white; font-weight: bold; margin-bottom: 10px;">Datos de tu cuenta:</p>
                        <p style="color: #888; font-size: 14px;">Usuario: <strong style="color: white;">{{ $user->name }}</strong></p>
                        <p style="color: #888; font-size: 14px;">Plan: <strong style="color: white;">{{ $plan->name }}</strong></p>
                    </div>
                </div>

                <!-- Acciones -->
                <div style="display: flex; gap: 15px; flex-direction: column;">
                    <a href="{{ route('dashboard') }}" style="display: block; width: 100%; background-color: #2563eb; color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; text-align: center;">
                        Ir al Dashboard
                    </a>

                    <a href="{{ route('home') }}" style="display: block; width: 100%; background-color: #333; color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; text-align: center; border: 1px solid #555;">
                        Volver al Inicio
                    </a>
                </div>

                <!-- Información -->
                <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #333;">
                    <p style="color: #666; font-size: 14px; text-align: center;">
                        El pago será registrado en el sistema de caja cuando el administrador abra la caja del día.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
