<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        
        <div style="margin-bottom: 40px;">
            <h2 class="anton-text text-secundario" style="font-size: 42px;">
                MIS <span class="text-terciario">RESERVAS</span>
            </h2>
            <p style="color: #888; font-size: 16px;">Aquí tienes las sesiones en las que vas a darlo todo.</p>
        </div>

        @if(session('success'))
            <div id="session-success" data-message="{{ session('success') }}" style="display: none;"></div>
        @endif

        @if($events->isEmpty())
            <div style="text-align: center; padding: 60px; background: #111; border: 1px solid #333; border-radius: 12px;">
                <p style="color: #666; font-size: 18px; margin-bottom: 20px;">No tienes reservas activas por ahora.</p>
                <a href="{{ route('events.index') }}" class="btn-primary" style="text-decoration: none;">EXPLORAR CALENDARIO</a>
            </div>
        @else
            <div id="my-classes-container" 
                 data-route-cancel="{{ route('events.cancel', ':id') }}"
                 data-csrf="{{ csrf_token() }}"
                 style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                
                @foreach($events as $event)
                    @php
                        $start = \Carbon\Carbon::parse($event->start_time);
                    @endphp
                    <div style="background: #111; border: 1px solid #222; border-left: 4px solid var(--color-terciario); border-radius: 8px; padding: 20px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                            <h3 class="anton-text text-secundario" style="font-size: 22px; margin: 0;">{{ $event->name }}</h3>
                            <span style="background: rgba(215, 38, 56, 0.1); color: var(--color-terciario); padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">CONFIRMADA</span>
                        </div>

                        <div style="color: #ccc; font-size: 14px; margin-bottom: 20px;">
                            <div style="margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <x-lucide-calendar-days style="width: 18px; height: 18px; stroke-width: 2; color: currentColor;" /> {{ $start->translatedFormat('l, d \d\e F') }}
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <x-lucide-clock style="width: 18px; height: 18px; stroke-width: 2; color: currentColor;" /> {{ $start->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                            </div>
                        </div>

                        <button class="btn-cancel-class" 
                                data-id="{{ $event->id }}" 
                                data-name="{{ $event->name }}"
                                style="width: 100%; padding: 10px; background: transparent; border: 1px solid #444; color: #888; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.3s;"
                                onmouseover="this.style.borderColor='var(--color-terciario)'; this.style.color='var(--color-terciario)'"
                                onmouseout="this.style.borderColor='#444'; this.style.color='#888'">
                            CANCELAR SESIÓN
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="{{ asset('js/my-classes-client.js') }}"></script>
</x-app-layout>