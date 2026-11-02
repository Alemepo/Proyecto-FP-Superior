<x-app-layout>
    {{--
        Vista: Accesos hoy

        Esta pantalla recibe desde AdminController dos variables:
        - $accessLogs: accesos del día agrupados por usuario.
        - $totalAccesses: número total de accesos registrados hoy.

        Sirve para que el administrador pueda ver quién ha entrado hoy,
        a qué hora entró, si salió, y si una persona ha entrado varias veces.
    --}}

    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">

        {{-- Cabecera de la página --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 class="anton-text text-secundario" style="margin-bottom: 5px;">
                    ACCESOS <span class="text-terciario">HOY</span>
                </h2>

                <p style="color: #888; margin: 0;">
                    Control diario de entradas por usuario.
                </p>
            </div>

            {{-- Botones de navegación --}}
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.scanner') }}" class="btn-primary" style="text-decoration: none;">
                    Abrir Escáner
                </a>

                <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none;">
                    Volver al Panel
                </a>
            </div>
        </div>

        {{-- Muestra el número total de accesos registrados hoy --}}
        <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; padding: 25px; margin-bottom: 30px;">
            <p style="color: #aaa; margin-bottom: 5px;">
                Total accesos registrados hoy
            </p>

            <h3 class="anton-text text-secundario" style="font-size: 42px; margin: 0;">
                {{ $totalAccesses }}
            </h3>
        </div>

        {{--
            Si no hay accesos registrados hoy, mostramos un mensaje.
            isEmpty() comprueba si la colección no tiene datos.
        --}}
        @if($accessLogs->isEmpty())
            <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; padding: 30px; text-align: center;">
                <p style="color: #888; margin: 0;">
                    Todavía no hay accesos registrados hoy.
                </p>
            </div>
        @else

            {{--
                Si hay accesos, recorremos cada grupo de accesos.

                En el controlador se hizo:
                groupBy('user_id')

                Por eso aquí cada $logs contiene todos los accesos
                de un mismo usuario.
            --}}
            <div style="display: grid; gap: 20px;">
                @foreach($accessLogs as $logs)
                    @php
                        /*
                            Cogemos el usuario del primer acceso.

                            Como $logs está agrupado por usuario,
                            todos los accesos de este grupo pertenecen
                            a la misma persona.
                        */
                        $user = $logs->first()->user;

                        /*
                            Contamos cuántas entradas tiene este usuario hoy.
                            Si tiene más de una, mostraremos un aviso.
                        */
                        $entryCount = $logs->count();
                    @endphp

                    <div style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 25px;">

                        {{-- Datos principales del usuario --}}
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 20px; flex-wrap: wrap;">
                            <div>
                                {{--
                                    ?-> evita error si el usuario no existe.
                                    ?? muestra "Usuario eliminado" si no hay usuario.
                                --}}
                                <h3 class="text-secundario" style="margin: 0;">
                                    {{ $user?->name ?? 'Usuario eliminado' }}
                                </h3>

                                @if($user)
                                    <p style="color: #888; margin: 5px 0 0;">
                                        {{ $user->email }}
                                    </p>
                                @endif
                            </div>

                            {{-- Número de entradas de este usuario hoy --}}
                            <strong style="color: {{ $entryCount > 1 ? '#f59e0b' : '#10b981' }};">
                                {{ $entryCount }} {{ $entryCount === 1 ? 'entrada' : 'entradas' }}
                            </strong>
                        </div>

                        {{--
                            Si el usuario tiene más de una entrada hoy,
                            mostramos un aviso para que el admin lo revise.
                        --}}
                        @if($entryCount > 1)
                            <p style="color: #f59e0b;">
                                Atención: este usuario ha registrado más de una entrada hoy.
                            </p>
                        @endif

                        {{-- Tabla con las entradas y salidas del usuario --}}
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 1px solid #333;">
                                    <th style="text-align: left; color: #aaa; padding: 10px;">Entrada</th>
                                    <th style="text-align: left; color: #aaa; padding: 10px;">Salida</th>
                                    <th style="text-align: left; color: #aaa; padding: 10px;">Estado</th>
                                </tr>
                            </thead>

                            <tbody>
                                {{-- Recorremos cada acceso del usuario --}}
                                @foreach($logs as $log)
                                    <tr style="border-bottom: 1px solid #222;">
                                        <td style="color: #fff; padding: 10px;">
                                            {{ $log->entry_time->format('H:i:s') }}
                                        </td>

                                        <td style="color: #fff; padding: 10px;">
                                            {{ $log->exit_time ? $log->exit_time->format('H:i:s') : '-' }}
                                        </td>

                                        <td style="color: #fff; padding: 10px;">
                                            {{ $log->exit_time ? 'Salió' : 'Dentro' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-app-layout>