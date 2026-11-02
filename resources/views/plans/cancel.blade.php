<x-app-layout>
    <div style="background-color: var(--color-principal); padding: 40px 20px;">
        <div class="container">
            <div style="max-width: 600px; margin: 0 auto; text-align: center;">
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 40px;">
                    <x-lucide-heart-crack style="width: 60px; height: 60px; stroke-width: 2; color: var(--color-terciario);" />
                    <h1 class="text-terciario" style="font-size: 32px; margin-bottom: 15px;">VUELVE PRONTO, ¡NECESITAMOS TU DINERO!</h1>
                    <p style="color: #ccc; margin-bottom: 10px;">Esperamos poder estafarte nuevamente pronto <strong style="color: var(--color-terciario);">{{ explode(' ', Auth::user()->name)[0] }}</strong></p>
                    <p style="color: #888; margin-bottom: 30px;">Ahora somos un poco más pobres. Disfruta de tu libertad...</p>
                    
                    <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="{{ route('dashboard') }}" class="btn-primary" style="text-decoration: none;">IR A MI PANEL</a>
                        <a href="{{ route('plans.index') }}" class="btn-secondary" style="text-decoration: none;">VER PLANES</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>