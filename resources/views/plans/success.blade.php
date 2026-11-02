<x-app-layout>
    <div style="background-color: var(--color-principal); padding: 40px 20px;">
        <div class="container">
            <div style="max-width: 600px; margin: 0 auto; text-align: center;">
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 40px;">
                    <div style="display: flex; justify-content: center; margin-bottom: 30px;">
                        <div style="width: 80px; height: 80px; background-color: rgba(74, 222, 128, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #4ade80;">
                            <x-lucide-check style="width: 40px; height: 40px; stroke-width: 2; color: #4ade80;" />
                        </div>
                    </div>
                    <h1 class="text-terciario" style="font-size: 32px; margin-bottom: 15px;">¡GRACIAS POR EL DINERO!</h1>
                    <p style="color: #ccc; margin-bottom: 10px;">Te hemos estafado exitosamente con el plan <strong style="color: var(--color-terciario);">{{ $plan->name }}</strong> de <strong style="color: var(--color-terciario);">{{ $plan->price }}€</strong></p>
                    <p style="color: #888; margin-bottom: 30px;">Ahora somos un poco más ricos. Disfruta de tu membresía... mientras dure.</p>
                    
                    <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="{{ route('dashboard') }}" class="btn-primary" style="text-decoration: none;">IR A MI PANEL</a>
                        <a href="{{ route('plans.index') }}" class="btn-secondary" style="text-decoration: none;">VER OTROS PLANES</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>