document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Mostrar mensaje de éxito si cancelamos una clase y recarga la página
    const successMsgEl = document.getElementById('session-success');
    if (successMsgEl) {
        Swal.fire({
            icon: 'success',
            title: '¡Plaza liberada!',
            text: successMsgEl.dataset.message,
            background: '#111',
            color: '#fff',
            confirmButtonColor: '#10b981'
        });
    }

    // 2. Comprobar si hay clases en la pantalla
    const container = document.getElementById('my-classes-container');
    if (!container) return; // Si la lista está vacía, no ejecutamos lo demás

    const cancelRouteTemplate = container.dataset.routeCancel;
    const csrfToken = container.dataset.csrf;

    // 3. Seleccionar todos los botones de "Cancelar Sesión"
    const cancelButtons = document.querySelectorAll('.btn-cancel-class');

    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Leer los datos específicos de la clase que se ha clickeado
            const eventId = this.dataset.id;
            const eventName = this.dataset.name;

            Swal.fire({
                title: '¿Anular reserva?',
                text: `¿Estás seguro de que quieres desapuntarte de ${eventName}?`,
                icon: 'warning',
                showCancelButton: true,
                background: '#111',
                color: '#fff',
                confirmButtonColor: '#d72638',
                cancelButtonColor: '#333',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'Volver'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = cancelRouteTemplate.replace(':id', eventId);
                    
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${csrfToken}"> 
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

});