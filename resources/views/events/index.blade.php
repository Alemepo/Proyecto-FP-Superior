<x-app-layout>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        
        <div style="margin-bottom: 40px; text-align: center;">
            <h2 class="anton-text text-secundario" style="font-size: 42px;">
                RESERVA TU <span class="text-terciario">SESIÓN</span>
            </h2>
            <p style="color: #888; font-size: 16px;">Gestiona tus entrenamientos desde el calendario interactivo.</p>
        </div>

        @if(session('success'))
            <div id="session-success" data-message="{{ session('success') }}" style="display: none;"></div>
        @endif

        <div style="background: #111; padding: 20px; border-radius: 12px; border: 1px solid #333; margin-bottom: 25px; display: flex; gap: 15px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <div style="position: relative; width: 100%;">
    
                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #888; pointer-events: none; display: flex;">
                    <x-lucide-search style="width: 20px; height: 20px; stroke-width: 2; color: currentColor;" />
                </div>

                <input type="text" id="calendarSearch" placeholder="Buscar clase..."
                    style="width: 100%; padding: 12px 12px 12px 40px; background: #000; border: 1px solid #444; color: #fff; border-radius: 8px; outline: none; transition: border 0.3s;"
                    onfocus="this.style.borderColor='var(--color-terciario)'" 
                    onblur="this.style.borderColor='#444'">
                    
            </div>
            
            <label style="color: #fff; display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px; font-weight: bold; padding: 10px 15px; background: #1a1a1a; border-radius: 8px; border: 1px solid #333;">
                <input type="checkbox" id="onlyMyClasses" style="accent-color: var(--color-terciario); width: 18px; height: 18px; cursor: pointer;">
                Mostrar solo mis clases
            </label>
        </div>

        <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">
            <span style="display: flex; align-items: center; gap: 8px; color: #ccc; font-size: 13px;"><div style="width: 10px; height: 10px; background: #10b981; border-radius: 50%;"></div> Disponible</span>
            <span style="display: flex; align-items: center; gap: 8px; color: #ccc; font-size: 13px;"><div style="width: 10px; height: 10px; background: #3b82f6; border-radius: 50%;"></div> Apuntado</span>
            <span style="display: flex; align-items: center; gap: 8px; color: #ccc; font-size: 13px;"><div style="width: 10px; height: 10px; background: #ef4444; border-radius: 50%;"></div> Lleno</span>
            <span style="display: flex; align-items: center; gap: 8px; color: #ccc; font-size: 13px;"><div style="width: 10px; height: 10px; background: #444; border-radius: 50%;"></div> Pasado</span>
        </div>

        <div style="background-color: #0a0a0a; border: 1px solid #222; border-radius: 12px; padding: 10px;">
            <div id="calendar" 
                 data-events="{{ json_encode($events) }}"
                 data-route-reserve="{{ route('events.reserve', ':id') }}"
                 data-route-cancel="{{ route('events.cancel', ':id') }}"
                 data-csrf="{{ csrf_token() }}">
            </div>
        </div>

    </div>

    <script src="{{ asset('js/calendar-client.js') }}"></script>
</x-app-layout>