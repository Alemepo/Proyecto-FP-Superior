<x-app-layout>

    <style>
        .stripe-card {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
    </style>

    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-terciario" style="font-size: 36px; margin-bottom: 10px;">PAGAR CON STRIPE</h1>
                <p style="color: #888; font-size: 16px;">Completa tu compra para {{ $plan->name }}</p>
            </div>

            <div style="max-width: 600px; margin: 0 auto;">

            @if(session('error'))
    <div style="background:#7f1d1d; color:white; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #ef4444;">
        <strong>Error:</strong> {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div style="background:#14532d; color:white; padding:15px; border-radius:8px; margin-bottom:20px; border:1px solid #22c55e;">
        {{ session('success') }}
    </div>
@endif

                <!-- Resumen del Pedido -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;" class="stripe-card">
                    <h2 style="color: var(--color-terciario); font-size: 24px; margin-bottom: 20px;">Resumen del Pedido</h2>

                    <!-- Plan -->
                    <div style="background-color: #222; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #333;">
                            <div>
                                <h3 style="color: white; font-size: 18px; font-weight: bold;">{{ $plan->name }}</h3>
                                <p style="color: #888; font-size: 14px;">Plan de suscripción mensual</p>
                            </div>
                            <span style="color: var(--color-terciario); font-size: 24px; font-weight: bold;">€{{ number_format($plan->price, 2) }}</span>
                        </div>

                        @if($plan->description)
                            <div style="color: #ccc; font-size: 14px;">
                                @foreach(explode("\n", $plan->description) as $feature)
                                    @if(trim($feature))
                                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                                            <span style="color: var(--color-terciario); margin-right: 8px;">✓</span>
                                            {{ trim($feature) }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Usuario -->
                    @auth
                        <div style="padding: 15px; background-color: #222; border-radius: 8px; margin-bottom: 20px;">
                            <p style="color: #888; font-size: 14px; margin-bottom: 5px;">Cuenta de usuario</p>
                            <p style="color: white; font-weight: bold;">{{ Auth::user()->name }}</p>
                            <p style="color: #666; font-size: 14px;">{{ Auth::user()->email }}</p>
                        </div>
                    @endauth

                    <!-- Total -->
                    <div style="background-color: rgba(239, 68, 68, 0.1); border: 1px solid var(--color-terciario); border-radius: 8px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #888;">Total a pagar:</span>
                            <span style="color: var(--color-terciario); font-size: 28px; font-weight: bold;">€{{ number_format($plan->price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Pago -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;" class="stripe-card">
                    <form id="checkout-form" method="POST" action="{{ route('stripe.plan.session', $plan) }}">
                        @csrf

                        <!-- Información de Stripe -->
                        <div style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                            <p style="color: #60a5fa; font-weight: bold; margin-bottom: 8px;">💡 Modo de Pruebas Activado</p>
                            <p style="color: #93c5fd; font-size: 14px;">Usa la tarjeta de prueba:</p>
                            <p style="color: #bfdbfe; font-family: monospace; font-size: 14px; margin: 5px 0;">4242 4242 4242 4242</p>
                            <p style="color: #93c5fd; font-size: 14px;">Vencimiento: 12/25 | CVC: 123</p>
                        </div>

                        <!-- Botón de Pago -->
                        <button type="submit" style="width: 100%; background-color: var(--color-terciario); color: white; border: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                            Proceder al Pago
                        </button>

                        <!-- Volver -->
                        <a href="{{ route('plans.index') }}" style="display: block; width: 100%; text-align: center; background-color: #333; color: #ccc; text-decoration: none; padding: 12px; border-radius: 8px; font-size: 16px; font-weight: bold; margin-top: 15px; border: 1px solid #555;">
                            Volver a Planes
                        </a>
                    </form>

                    <!-- Garantía -->
                    <div style="text-align: center; margin-top: 20px; padding: 15px; background-color: #222; border-radius: 8px; border: 1px solid #333;">
                        <p style="color: #ccc; margin-bottom: 8px;">✓ Garantía 100% seguro</p>
                        <p style="color: #666; font-size: 12px;">Powered by <span style="color: #60a5fa;">Stripe</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
