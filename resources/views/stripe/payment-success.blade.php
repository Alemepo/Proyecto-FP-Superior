<x-app-layout>
    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">
            <div style="max-width: 600px; margin: 0 auto; text-align: center;">

                <!-- Icono de éxito -->
                <div style="margin-bottom: 30px;">
                    <div style="display: inline-flex; align-items: center; justify-content: center; width: 80px; height: 80px; background-color: #10b981; border-radius: 50%;">
                        <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Título -->
                <h1 style="color: #10b981; font-size: 36px; font-weight: bold; margin-bottom: 10px;">¡PAGO EXITOSO!</h1>
                <p style="color: #888; font-size: 16px; margin-bottom: 40px;">Tu suscripción ha sido procesada correctamente</p>

                <!-- Resumen -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px; text-align: left;">
                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #333;">
                        <p style="color: #888; font-size: 14px;">Usuario</p>
                        <p style="color: white; font-size: 18px; font-weight: bold;">{{ $user->name }}</p>
                    </div>

                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #333;">
                        <p style="color: #888; font-size: 14px;">Correo</p>
                        <p style="color: white; font-size: 18px; font-weight: bold;">{{ $user->email }}</p>
                    </div>

                    <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #333;">
                        <p style="color: #888; font-size: 14px;">Plan Contratado</p>
                        <p style="color: white; font-size: 18px; font-weight: bold;">{{ $plan->name }}</p>
                    </div>

                    <div>
                        <p style="color: #888; font-size: 14px;">Importe Pagado</p>
                        <p style="color: #10b981; font-size: 28px; font-weight: bold;">€{{ number_format($plan->price, 2) }}</p>
                    </div>
                </div>

                <!-- Acciones -->
                <div style="display: flex; gap: 15px; flex-direction: column;">
                    <a href="{{ route('dashboard') }}" style="display: block; width: 100%; background-color: var(--color-terciario); color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; text-align: center;">
                        Ir al Dashboard
                    </a>

                    <a href="{{ route('home') }}" style="display: block; width: 100%; background-color: #333; color: white; text-decoration: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; text-align: center; border: 1px solid #555;">
                        Volver al Inicio
                    </a>
                </div>

                <!-- Información -->
                <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #333;">
                    <p style="color: #666; font-size: 14px; text-align: center; margin-bottom: 15px;">
                        Se ha enviado un correo de confirmación a tu dirección de email.
                    </p>
                    <p style="color: #888; font-size: 14px; text-align: center;">
                        Si tienes preguntas, contacta con nuestro equipo de soporte.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
