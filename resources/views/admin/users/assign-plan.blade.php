<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 class="anton-text text-secundario" style="margin-bottom: 5px; font-size: 32px;">
                    ASIGNAR <span class="text-terciario">PLAN Y COBRAR</span>
                </h2>
                <p style="color: #888; margin: 0;">Asigna un nuevo plan a <strong>{{ $user->name }}</strong> y registra el pago en caja.</p>
            </div>
            
            <a href="{{ route('admin.users') }}" class="btn-secondary" style="text-decoration: none; font-size: 14px;">
                Volver a Usuarios
            </a>
        </div>

        @if(session('error'))
            <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; padding: 30px; max-width: 800px; margin: 0 auto;">
            <div style="margin-bottom: 30px; background: #1a1a1a; padding: 20px; border-radius: 8px; border-left: 4px solid var(--color-terciario);">
                <h3 style="color: #fff; margin-bottom: 10px; font-size: 18px;">Datos del Cliente</h3>
                <p style="color: #aaa; margin: 0;"><strong>Nombre:</strong> {{ $user->name }}</p>
                <p style="color: #aaa; margin: 5px 0 0 0;"><strong>Email:</strong> {{ $user->email }}</p>
                <p style="color: #aaa; margin: 5px 0 0 0;"><strong>Plan Actual:</strong> {{ $user->plan ? $user->plan->name : 'Ninguno' }}</p>
            </div>

            <form action="{{ route('admin.users.assign-plan.store', $user) }}" method="POST">
                @csrf
                
                <h3 style="color: #fff; margin-bottom: 20px;">Selección de Plan y Pago</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label for="plan_id" style="color: #aaa; font-weight: bold;">Nuevo Plan de Membresía *</label>
                        <select id="plan_id" name="plan_id" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                            <option value="">Seleccionar Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $user->plan_id == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} - {{ number_format($plan->price, 2) }}€
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="payment_method" style="color: #aaa; font-weight: bold;">Método de Pago en Recepción *</label>
                        <select id="payment_method" name="payment_method" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                            <option value="">Seleccionar Método</option>
                            <option value="cash">Efectivo</option>
                            <option value="card">Tarjeta</option>
                        </select>
                        <p style="color: #888; font-size: 12px; margin-top: 5px;">Se registrará el ingreso automáticamente en la caja de hoy por el valor del plan seleccionado.</p>
                    </div>
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn-primary" style="padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">GUARDAR Y PROCESAR</button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
