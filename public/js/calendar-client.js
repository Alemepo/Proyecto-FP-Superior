document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    // Leer los datos pasados desde Laravel a través de atributos de datos HTML
    const eventsData = JSON.parse(calendarEl.dataset.events);
    const reserveRoute = calendarEl.dataset.routeReserve;
    const cancelRoute = calendarEl.dataset.routeCancel;
    const csrfToken = calendarEl.dataset.csrf;

    const searchInput = document.getElementById('calendarSearch');
    const myClassesCheckbox = document.getElementById('onlyMyClasses');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        locale: 'es',
        firstDay: 1,
        buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana' },
        events: eventsData,

        eventContent: function(info) {
            let color = info.event.extendedProps.baseColor;
            let startTime = info.event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            let endTime = info.event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            return {
                html: `<div style="font-size: 13px; font-weight: bold; color: #fff; padding: 5px 8px; border-bottom: 3px solid ${color}; background-color: ${color}25; border-radius: 4px; width: 100%; box-sizing: border-box; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    ${info.event.title}<br><small style="font-size: 11px; opacity: 0.9;">${startTime} - ${endTime}</small>
                </div>`
            };
        },

        eventClick: function(info) {
            const status = info.event.extendedProps.status;
            const eventId = info.event.id;
            const title = info.event.extendedProps.rawName; // Usamos el nombre limpio
            const startTime = info.event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            const endTime = info.event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            const horario = `${startTime} - ${endTime}`;

            if (status === 'past') {
                Swal.fire({ title: 'Clase Finalizada', text: `${title}\n${horario}\n\nEsta sesión ya terminó.`, icon: 'info', background: '#111', color: '#fff', confirmButtonColor: '#444' });
                return;
            }

            if (status === 'full' && status !== 'booked') {
                Swal.fire({ title: 'Sin Plazas', text: `${title}\n${horario}\n\nEsta clase está completa.`, icon: 'warning', background: '#111', color: '#fff', confirmButtonColor: '#ef4444' });
                return;
            }

            if (status === 'booked') {
                Swal.fire({
                    title: '¿Anular reserva?',
                    text: `${title}\n${horario}\n\nVas a dejar tu plaza`,
                    icon: 'warning',
                    showCancelButton: true,
                    background: '#111',
                    color: '#fff',
                    confirmButtonColor: '#d72638',
                    cancelButtonColor: '#333',
                    confirmButtonText: 'Sí, desapuntarme',
                    cancelButtonText: 'Mantener reserva'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm(cancelRoute.replace(':id', eventId), 'DELETE');
                    }
                });
            } else {
                Swal.fire({
                    title: 'Confirmar Asistencia',
                    text: `${title}\n${horario}\n\n¿Quieres reservar tu plaza?`,
                    icon: 'question',
                    showCancelButton: true,
                    background: '#111',
                    color: '#fff',
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#333',
                    confirmButtonText: '¡Reservar!',
                    cancelButtonText: 'Ahora no'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm(reserveRoute.replace(':id', eventId), 'POST');
                    }
                });
            }
        }
    });

    calendar.render();

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const showOnlyMine = myClassesCheckbox.checked;
        calendar.getEvents().forEach(event => {
            const matchesSearch = event.title.toLowerCase().includes(searchTerm);
            const matchesMine = !showOnlyMine || event.extendedProps.isBooked;
            event.setProp('display', (matchesSearch && matchesMine) ? 'auto' : 'none');
        });
    }

    searchInput.addEventListener('input', applyFilters);
    myClassesCheckbox.addEventListener('change', applyFilters);

    function submitForm(action, method) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = action;
        form.innerHTML = `<input type="hidden" name="_token" value="${csrfToken}"> <input type="hidden" name="_method" value="${method}">`;
        document.body.appendChild(form);
        form.submit();
    }
});