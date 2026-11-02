<x-app-layout>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <h2 class="anton-text text-secundario" style="font-size: 36px; margin: 0;">
                    PLANIFICACIÓN DE <span class="text-terciario">SESIONES</span>
                </h2>
                <p style="color: #888; margin: 0;">Gestiona el horario semanal del gimnasio. Haz clic en un día para programar.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none; font-size: 14px;">
                Volver al Panel
            </a>
        </div>

        @if(session('success'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 4px; margin-bottom: 30px; color: #10b981;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 350px 1fr; gap: 30px; align-items: start;">
            
            <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; padding: 25px;" id="form-container">
                <h3 class="anton-text text-secundario" style="margin-bottom: 20px; font-size: 20px;">NUEVA CLASE</h3>

                <form method="POST" action="{{ route('admin.events.store') }}" id="event-form">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; color: #888; font-size: 12px; margin-bottom: 5px;">NOMBRE</label>
                        <input type="text" name="name" id="name-input" required style="width: 100%; padding: 10px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; color: #888; font-size: 12px; margin-bottom: 5px;">INICIO</label>
                        <input type="datetime-local" name="start_time" id="start-input" required style="width: 100%; padding: 10px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; color-scheme: dark; outline: none;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; color: #888; font-size: 12px; margin-bottom: 5px;">FIN</label>
                        <input type="datetime-local" name="end_time" id="end-input" required style="width: 100%; padding: 10px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; color-scheme: dark; outline: none;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; color: #888; font-size: 12px; margin-bottom: 5px;">PLAZAS</label>
                        <input type="number" name="capacity" value="20" style="width: 100%; padding: 10px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none;">
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; padding: 12px; font-weight: bold;">
                        CREAR CLASE
                    </button>
                </form>

                <hr style="border: 0; border-top: 1px solid #333; margin: 30px 0;">
                
                <h4 class="text-secundario" style="font-size: 14px; margin-bottom: 10px;">PRÓXIMAS HOY</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @forelse($events->where('start_time', '>=', now()->startOfDay())->take(3) as $e)
                        <div style="font-size: 13px; color: #ccc; background: #1a1a1a; padding: 10px; border-radius: 6px; border-left: 3px solid var(--color-terciario);">
                            <strong>{{ $e->name }}</strong><br>
                            <span style="color: #666;">{{ \Carbon\Carbon::parse($e->start_time)->format('H:i') }}</span>
                        </div>
                    @empty
                        <p style="color: #555; font-size: 12px;">No hay más clases hoy.</p>
                    @endforelse
                </div>
            </div>

            <div id='calendar-container'>
                <div id='calendar'></div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                locale: 'es',
                firstDay: 1, 
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana'
                },
                events: [
                    @foreach($events as $event)
                    {
                        id: '{{ $event->id }}',
                        title: '{{ $event->name }}',
                        start: '{{ $event->start_time }}',
                        end: '{{ $event->end_time }}',
                        backgroundColor: '{{ \Carbon\Carbon::parse($event->start_time)->isPast() ? "#333" : "#D72638" }}',
                        borderColor: '{{ \Carbon\Carbon::parse($event->start_time)->isPast() ? "#444" : "#D72638" }}',
                        extendedProps: {
                            capacity: {{ $event->capacity }}
                        }
                    },
                    @endforeach
                ],
                eventContent: function(info) {
                    let startTime = info.event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                    let endTime = info.event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                    let capacity = info.event.extendedProps.capacity;
                    return {
                        html: `<div style="font-size: 13px; font-weight: bold; color: #fff; padding: 5px 8px; border-bottom: 3px solid ${info.event.backgroundColor}; background-color: ${info.event.backgroundColor}25; border-radius: 4px; width: 100%; box-sizing: border-box; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            ${info.event.title} (${capacity} pl.)<br><small style="font-size: 11px; opacity: 0.9;">${startTime} - ${endTime}</small>
                        </div>`
                    };
                },
                // Borrar clase al hacer clic en el evento
                eventClick: function(info) {
                    if(confirm("¿Deseas eliminar la clase: " + info.event.title + "?")) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        
                        // 🔥 SOLUCIÓN: Usamos la ruta dinámica de Laravel y reemplazamos el ID
                        let actionUrl = '{{ route("admin.events.destroy", ":id") }}';
                        form.action = actionUrl.replace(':id', info.event.id);
                        
                        form.innerHTML = `@csrf @method('DELETE')`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                },
                // Autocompletar formulario al hacer clic en un día libre
                dateClick: function(info) {
                    const startInput = document.getElementById('start-input');
                    const endInput = document.getElementById('end-input');
                    const nameInput = document.getElementById('name-input');
                    
                    // Rellenamos las fechas automáticamente (ponemos las 10:00 y 11:00 por defecto)
                    startInput.value = info.dateStr + 'T10:00';
                    endInput.value = info.dateStr + 'T11:00';
                    
                    // Enfocamos el campo del nombre para que el admin pueda escribir directamente
                    nameInput.focus();
                    
                    // Efecto visual rápido en el formulario para indicar que se han rellenado los datos
                    document.getElementById('form-container').style.border = '1px solid var(--color-terciario)';
                    setTimeout(() => {
                        document.getElementById('form-container').style.border = '1px solid #333';
                    }, 500);
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>