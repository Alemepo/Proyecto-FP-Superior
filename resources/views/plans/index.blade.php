<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Clase para el efecto de zoom y elevación */
        .plan-card {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease, border-color 0.3s ease !important;
            cursor: pointer;
        }

        .plan-card:hover {
            transform: scale(1.05); /* El efecto de zoom */
            border-color: var(--color-terciario) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        /* Ajuste especial para la tarjeta que ya tiene un scale(1.02) por defecto */
        .plan-card-popular:hover {
            transform: scale(1.08) !important;
        }
    </style>

    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 100px 20px 60px;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h1 class="text-terciario" style="font-size: 48px; margin-bottom: 15px;">NUESTROS PLANES</h1>
                <p style="color: #888; font-size: 16px;">ELIGE EL PLAN QUE SE ADAPTE A TUS OBJETIVOS</p>
            </div>

            @if(session('error'))
                <div style="max-width: 900px; margin: 0 auto 30px auto; background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 15px; border-radius: 8px;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
                
                @forelse($plans as $plan)
                    @php
                        // Determinamos si es el plan "popular" para destacarlo (por ejemplo, si contiene la palabra 'Pro' o si es el segundo)
                        $isPopular = stripos($plan->name, 'pro') !== false;
                    @endphp

                    <div class="plan-card {{ $isPopular ? 'plan-card-popular' : '' }}" style="background-color: #111; border: {{ $isPopular ? '2px' : '1px' }} solid {{ $isPopular ? 'var(--color-terciario)' : '#333' }}; border-radius: 12px; overflow: hidden; {{ $isPopular ? 'transform: scale(1.02); position: relative;' : '' }} display: flex; flex-direction: column; height: 100%;">
                        
                        @if($isPopular)
                            <div style="position: absolute; top: 0; right: 0; background-color: var(--color-terciario); color: white; padding: 8px 20px; font-size: 12px; font-weight: bold; border-bottom-left-radius: 12px;">
                                MÁS POPULAR
                            </div>
                        @endif

                        <div style="padding: 30px; display: flex; flex-direction: column; flex-grow: 1;">
                            <h2 style="color: #fff; font-size: 28px; margin-bottom: 10px; text-align: center;">{{ strtoupper($plan->name) }}</h2>
                            <div style="text-align: center; margin-bottom: 25px;">
                                <span style="color: var(--color-terciario); font-size: 36px; font-weight: bold;">{{ number_format($plan->price, 0) }}€</span>
                                <span style="color: #888;">/MES</span>
                            </div>
                            
                            <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
                                @if($plan->description)
                                    @foreach(explode("\n", $plan->description) as $feature)
                                        @if(trim($feature) !== '')
                                            <li style="padding: 10px 0; border-bottom: 1px solid #222; color: #ccc; display: flex; align-items: center;">
                                                <span style="color: var(--color-terciario); margin-right: 10px;">✓</span> {{ trim($feature) }}
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                    <li style="padding: 10px 0; border-bottom: 1px solid #222; color: #888; text-align: center; font-style: italic;">
                                        Sin descripción detallada
                                    </li>
                                @endif
                            </ul>
                            
                            <div style="margin-top: auto;">
                                @auth
                                    @if(auth()->user()->plan_id == $plan->id)
                                        <div style="background-color: rgba(215, 38, 56, 0.1); border: 1px solid var(--color-terciario); border-radius: 8px; padding: 10px; text-align: center;">
                                            <span style="color: var(--color-terciario); font-size: 14px;">✓ PLAN ACTUAL</span>
                                        </div>
                                    @else
                                        <!-- Botón de Pago con Stripe -->
                                        <a href="{{ route('stripe.plan.checkout', $plan->id) }}" class="btn-primary" style="display: block; width: 100%; text-align: center; text-decoration: none; padding: 12px 20px; border-radius: 6px; margin-bottom: 10px; background-color: var(--color-terciario); color: white; font-weight: bold; transition: background-color 0.3s;">
                                            <x-lucide-credit-card style="width: 22px; height: 22px; stroke-width: 2; color: currentColor;" /> PAGAR CON STRIPE
                                        </a>

                                        <!-- Botón alternativo: Solo para admin sin pagar -->
                                        @if(auth()->user()->role === 'admin')
                                            <form method="POST" action="{{ route('plans.subscribe', $plan->id) }}" style="margin-top: 8px;">
                                                @csrf
                                                <button type="submit" class="btn-secondary" style="display: block; width: 100%; text-align: center; cursor: pointer; padding: 10px 20px; border-radius: 6px; border: 1px solid #333; background-color: transparent; color: #ccc; font-weight: bold; transition: all 0.3s;">
                                                    <x-lucide-notebook-pen style="width: 22px; height: 22px; stroke-width: 2; color: currentColor;" /> ASIGNAR SIN PAGAR
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                                
                                @guest
                                    <a href="{{ route('stripe.plan.checkout', $plan->id) }}" class="btn-primary" style="display: block; text-align: center; text-decoration: none; padding: 12px 20px; border-radius: 6px; background-color: var(--color-terciario); color: white; font-weight: bold; transition: background-color 0.3s;">
                                        <x-lucide-credit-card style="width: 22px; height: 22px; stroke-width: 2; color: currentColor;" /> PAGAR CON STRIPE
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; color: #888; padding: 40px;">
                        <p>No hay planes disponibles en este momento.</p>
                    </div>
                @endforelse
            </div>

            @auth
                @if(auth()->user()->plan_id)
                    <div class="flex-center" style="margin-top: 40px; text-align: center;">
                        <form method="POST" action="{{ route('plans.cancel') }}" 
                        onsubmit="event.preventDefault(); let form = this; Swal.fire({
                            title: '¿Anular plan?',
                            text: `Estás a punto de cancelar tu plan actual. ¿Deseas continuar?`,
                            icon: 'warning',
                            showCancelButton: true,
                            background: '#111',
                            color: '#fff',
                            confirmButtonColor: 'var(--color-terciario)',
                            cancelButtonColor: 'var(--color-se)',
                            confirmButtonText: 'Sí, anularlo',
                            cancelButtonText: 'No, mantenerlo'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // <-- Aquí es donde enviamos el formulario de verdad
                            }
                        })">
                            @csrf
                            <button type="submit" class="btn-secondary">
                                CANCELAR PLAN ACTUAL
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout>
