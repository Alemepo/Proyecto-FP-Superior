<x-app-layout>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stripe = Stripe('{{ config("services.stripe.public") }}');
            const form = document.getElementById('register-checkout-form');
            const btn = document.getElementById('checkout-btn');
            const errorContainer = document.getElementById('register-errors');

            if (!form) return;

            function showError(message) {
                if (errorContainer) {
                    errorContainer.textContent = message;
                    errorContainer.style.display = 'block';
                } else {
                    alert(message);
                }
            }

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                errorContainer.style.display = 'none';

                const name = document.querySelector('input[name="name"]').value.trim();
                const email = document.querySelector('input[name="email"]').value.trim();
                const termsAccepted = document.querySelector('input[name="terms"]').checked;

                if (!name) {
                    showError('Por favor ingresa tu nombre completo.');
                    document.querySelector('input[name="name"]').focus();
                    return;
                }

                if (!email) {
                    showError('Por favor ingresa tu correo electrónico.');
                    document.querySelector('input[name="email"]').focus();
                    return;
                }

                if (!termsAccepted) {
                    showError('Debes aceptar los términos y condiciones.');
                    document.querySelector('input[name="terms"]').focus();
                    return;
                }

                const originalHTML = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '⏳ Procesando...';

                try {
                    const response = await fetch('{{ route('stripe.plan.session', $plan) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email: email,
                            name: name
                        })
                    });

                    const data = await response.json();

                    if (data.error) {
                        showError('❌ Error: ' + data.error);
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                        return;
                    }

                    const result = await stripe.redirectToCheckout({
                        sessionId: data.session_id
                    });

                    if (result.error) {
                        showError('❌ Error: ' + result.error.message);
                        btn.disabled = false;
                        btn.innerHTML = originalHTML;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showError('❌ Error al procesar el pago');
                    btn.disabled = false;
                    btn.innerHTML = originalHTML;
                }
            });
        });
    </script>

    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 40px;">
                <h1 class="text-terciario" style="font-size: 36px; margin-bottom: 10px;">CREAR CUENTA Y PAGAR</h1>
                <p style="color: #888; font-size: 16px;">Crea tu cuenta y accede a {{ $plan->name }}</p>
            </div>

            <div style="max-width: 800px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

                <!-- Formulario de Registro -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                    <h2 style="color: white; font-size: 24px; margin-bottom: 20px;">Tu Información</h2>

                    <div id="register-errors" style="display: none; background-color: rgba(215, 38, 56, 0.15); border: 1px solid #D72638; color: white; padding: 14px; border-radius: 10px; margin-bottom: 20px; font-size: 14px;"></div>

                    <!-- Formulario -->
                    <form id="register-checkout-form">
                        @csrf

                        <!-- Nombre -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; color: #ccc; font-size: 14px; margin-bottom: 8px;">Nombre Completo *</label>
                            <input type="text" name="name" required placeholder="Juan Pérez"
                                style="width: 100%; padding: 12px; background-color: #222; border: 1px solid #333; border-radius: 8px; color: white; font-size: 16px;">
                        </div>

                        <!-- Email -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; color: #ccc; font-size: 14px; margin-bottom: 8px;">Correo Electrónico *</label>
                            <input type="email" name="email" required placeholder="juan@ejemplo.com"
                                style="width: 100%; padding: 12px; background-color: #222; border: 1px solid #333; border-radius: 8px; color: white; font-size: 16px;">
                        </div>

                        <!-- Resumen del Plan -->
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

                        <!-- Términos -->
                        <div style="padding: 15px; background-color: #222; border-radius: 8px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: start;">
                                <input type="checkbox" name="terms" id="terms" required style="margin-top: 3px; margin-right: 10px;">
                                <label for="terms" style="color: #ccc; font-size: 14px;">
                                    Acepto los <a href="#" style="color: var(--color-terciario); text-decoration: underline;">términos y condiciones</a>
                                    y la <a href="#" style="color: var(--color-terciario); text-decoration: underline;">política de privacidad</a>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Panel de Pago -->
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                    <h3 style="color: white; font-size: 20px; margin-bottom: 20px;">Resumen</h3>

                    <!-- Total -->
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <span style="color: #888;">Plan:</span>
                            <span style="color: white; font-weight: bold;">{{ $plan->name }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid #333;">
                            <span style="color: #888;">Precio:</span>
                            <span style="color: white;">€{{ number_format($plan->price, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                            <span style="color: #888; font-weight: bold;">Total:</span>
                            <span style="color: var(--color-terciario); font-size: 24px; font-weight: bold;">€{{ number_format($plan->price, 2) }}</span>
                        </div>
                    </div>

                    <!-- Información de Stripe -->
                    <div style="background-color: rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
                        <p style="color: #60a5fa; font-weight: bold; margin-bottom: 8px;">💡 Modo de Pruebas</p>
                        <p style="color: #93c5fd; font-size: 14px;">Tarjeta de prueba:</p>
                        <p style="color: #bfdbfe; font-family: monospace; font-size: 14px; margin: 5px 0;">4242 4242 4242 4242</p>
                        <p style="color: #93c5fd; font-size: 14px;">Exp: 12/25 | CVC: 123</p>
                    </div>

                    <!-- Botón de Pago -->
                    <button type="submit" form="register-checkout-form" id="checkout-btn" style="width: 100%; background-color: var(--color-terciario); color: white; border: none; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                        Crear & Pagar
                    </button>

                    <!-- Volver -->
                    <a href="{{ route('home') }}" style="display: block; width: 100%; text-align: center; background-color: #333; color: #ccc; text-decoration: none; padding: 12px; border-radius: 8px; font-size: 16px; font-weight: bold; margin-top: 15px; border: 1px solid #555;">
                        Volver
                    </a>

                    <!-- Seguridad -->
                    <div style="text-align: center; margin-top: 20px; padding: 15px; background-color: #222; border-radius: 8px;">
                        <p style="color: #ccc; margin-bottom: 8px;">🔒 Totalmente Seguro</p>
                        <p style="color: #666; font-size: 12px;">Powered by <span style="color: #60a5fa;">Stripe</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
