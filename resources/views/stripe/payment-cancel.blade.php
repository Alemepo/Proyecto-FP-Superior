<x-app-layout>
    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">
            <div style="max-width: 600px; margin: 0 auto; text-align: center;">

                <!-- Icono de error -->
                <div style="margin-bottom: 30px;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; background-color: #ef4444; border-radius: 50%;">
                        <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>

                <!-- Título -->
                <h1 style="color: #ef4444; font-size: 36px; font-weight: bold; margin-bottom: 10px;">PAGO CANCELADO</h1>
                <p style="color: #888; font-size: 16px; margin-bottom: 40px;">Tu transacción ha sido cancelada</p>

                <!-- Mensaje -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                    <p style="color: #ccc; font-size: 16px;">
                        No hemos cobrado ningún importe en tu cuenta. Si lo deseas, puedes intentar el pago nuevamente.
                    </p>
                </div>

                <!-- Acciones -->
                <div style="display: flex; gap: 15px; flex-direction: column;">
                    <a href="{{ route('plans.index') }}" style="display: block; width: 100%; background-color: var(--color-terciario); color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; text-align: center;">
                        Reintentar Pago
                    </a>

                    <a href="{{ route('home') }}" style="display: block; width: 100%; background-color: #333; color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; text-align: center; border: 1px solid #555;">
                        Volver al Inicio
                    </a>
                </div>

                <!-- Información -->
                <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #333;">
                    <p style="color: #666; font-size: 14px; text-align: center;">
                        ¿Necesitas ayuda? Contacta con nuestro equipo de soporte.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
