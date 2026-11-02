<x-app-layout>
    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">

            {{-- Traducciones para mostrar los valores internos de base de datos en español --}}
            @php
                $categoryLabels = [
                    
                    'product' => 'Producto',
                    'withdrawal' => 'Retirada',
                    'adjustment' => 'Otros',
                ];

                $paymentLabels = [
                    'cash' => 'Efectivo',
                    'card' => 'Tarjeta',
                    'stripe' => 'Stripe',
                    'other' => 'Otros',
                ];

                $selectedDateFormatted = \Carbon\Carbon::parse($selectedDate)->format('d/m/Y');
            @endphp

            {{-- Cabecera principal --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; gap: 20px; flex-wrap: wrap;">
                <div>
                    <h1 class="text-secundario" style="font-size: 48px; margin: 0;">
                        GESTIÓN DE <span class="text-terciario">CAJA</span>
                    </h1>

                    <p style="color: #888; margin-top: 8px;">
                        Control diario de ingresos, gastos y cierre de caja.
                    </p>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none; font-size: 14px;">
                    Volver al Panel
                </a>
            </div>

            {{-- Selector de fecha --}}
            <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                <h2 class="text-terciario" style="margin-bottom: 20px;">
                    CONSULTAR CAJA
                </h2>

                <form method="GET" action="{{ route('admin.cash.index') }}" style="display: flex; gap: 15px; align-items: end; flex-wrap: wrap;">
                    <div>
                        <label class="text-secundario">Seleccionar fecha</label>

                        <input
                            type="date"
                            name="date"
                            value="{{ $selectedDate }}"
                            style="padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                        >
                    </div>

                    <button type="submit" class="btn-primary" style="padding: 12px 20px;">
                        VER CAJA
                    </button>

                    <a href="{{ route('admin.cash.index') }}" class="btn-secondary" style="text-decoration: none; padding: 12px 20px;">
                        HOY
                    </a>
                </form>
            </div>

            {{-- Historial rápido de cajas --}}
            @if ($cashClosures->count())
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                    <h2 class="text-terciario" style="margin-bottom: 20px;">
                        HISTORIAL DE CAJAS
                    </h2>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @foreach ($cashClosures as $closure)
                            @php
                                $closureDate = $closure->cash_date->format('Y-m-d');
                                $isSelected = $selectedDate === $closureDate;
                            @endphp

                            <a
                                href="{{ route('admin.cash.index', ['date' => $closureDate]) }}"
                                style="
                                    text-decoration: none;
                                    padding: 10px 14px;
                                    border-radius: 8px;
                                    border: 1px solid {{ $isSelected ? 'var(--color-terciario)' : '#444' }};
                                    background-color: {{ $isSelected ? 'var(--color-terciario)' : '#000' }};
                                    color: #fff;
                                    font-weight: bold;
                                    font-size: 14px;
                                "
                            >
                                {{ $closure->cash_date->format('d/m/Y') }}
                                -
                                {{ $closure->status === 'open' ? 'Abierta' : 'Cerrada' }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Mensajes de éxito o error --}}
            @if (session('success'))
                <div style="background-color: rgba(34, 197, 94, 0.15); border: 1px solid #22c55e; color: #86efac; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 15px; border-radius: 8px; margin-bottom: 25px;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Si no existe caja para la fecha seleccionada, se muestra formulario para abrirla --}}
            @if (!$cashClosure)
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                    <h2 class="text-terciario" style="margin-bottom: 20px;">
                        ABRIR CAJA DEL {{ $selectedDateFormatted }}
                    </h2>

                    <p style="color: #888; margin-bottom: 20px;">
                        No existe ninguna caja creada para esta fecha. Puedes abrirla desde aquí.
                    </p>

                    <form method="POST" action="{{ route('admin.cash.open') }}">
                        @csrf

                        {{-- Fecha para la que se abrirá la caja --}}
                        <input type="hidden" name="cash_date" value="{{ $selectedDate }}">

                        <div style="margin-bottom: 20px;">
                            <label class="text-secundario">Saldo de apertura *</label>

                            <input
                                type="number"
                                name="opening_amount"
                                step="0.01"
                                min="0"
                                value="{{ old('opening_amount', 0) }}"
                                required
                                style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                            >

                            @error('opening_amount')
                                <p style="color: #ef4444; margin-top: 8px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn-primary" style="padding: 14px 24px;">
                            ABRIR CAJA
                        </button>
                    </form>
                </div>
            @else

                {{-- Resumen principal --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid var(--color-terciario); border-radius: 12px; padding: 25px;">
                        <p style="color: #aaa; margin: 0; font-size: 13px; font-weight: bold;">SALDO APERTURA</p>

                        <h2 class="text-secundario" style="font-size: 36px; margin-top: 10px;">
                            {{ number_format($cashClosure->opening_amount, 2) }} €
                        </h2>
                    </div>

                    <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #22c55e; border-radius: 12px; padding: 25px;">
                        <p style="color: #aaa; margin: 0; font-size: 13px; font-weight: bold;">INGRESOS</p>

                        <h2 style="color: #22c55e; font-size: 36px; margin-top: 10px;">
                            {{ number_format($totalIncome, 2) }} €
                        </h2>
                    </div>

                    <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #ef4444; border-radius: 12px; padding: 25px;">
                        <p style="color: #aaa; margin: 0; font-size: 13px; font-weight: bold;">GASTOS / RETIRADAS</p>

                        <h2 style="color: #ef4444; font-size: 36px; margin-top: 10px;">
                            {{ number_format($totalExpense, 2) }} €
                        </h2>
                    </div>

                    <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #3b82f6; border-radius: 12px; padding: 25px;">
                        <p style="color: #aaa; margin: 0; font-size: 13px; font-weight: bold;">SALDO ACTUAL</p>

                        <h2 class="text-secundario" style="font-size: 36px; margin-top: 10px;">
                            {{ number_format($currentBalance, 2) }} €
                        </h2>
                    </div>
                </div>

                {{-- Resumen por método de pago --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 20px;">
                        <p style="color: #888; margin: 0;">Ingresos efectivo</p>

                        <h3 class="text-secundario" style="font-size: 26px; margin-top: 8px;">
                            {{ number_format($cashIncome, 2) }} €
                        </h3>
                    </div>

                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 20px;">
                        <p style="color: #888; margin: 0;">Ingresos tarjeta</p>

                        <h3 class="text-secundario" style="font-size: 26px; margin-top: 8px;">
                            {{ number_format($cardIncome, 2) }} €
                        </h3>
                    </div>

                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 20px;">
                        <p style="color: #888; margin: 0;">Ingresos Stripe</p>

                        <h3 class="text-secundario" style="font-size: 26px; margin-top: 8px;">
                            {{ number_format($stripeIncome, 2) }} €
                        </h3>
                    </div>

                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 20px;">
                        <p style="color: #888; margin: 0;">Ingresos otros</p>

                        <h3 class="text-secundario" style="font-size: 26px; margin-top: 8px;">
                            {{ number_format($otherIncome, 2) }} €
                        </h3>
                    </div>
                </div>

                {{-- Información de la caja --}}
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap;">
                        <div>
                            <h2 class="text-secundario" style="margin: 0;">
                                CAJA DEL {{ $cashClosure->cash_date->format('d/m/Y') }}
                            </h2>

                            <p style="color: #aaa; margin-top: 8px;">
                                Estado:
                                @if ($cashClosure->status === 'open')
                                    <span style="color: #22c55e; font-weight: bold;">Abierta</span>
                                @else
                                    <span style="color: #ef4444; font-weight: bold;">Cerrada</span>
                                @endif
                            </p>
                        </div>

                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            {{-- Enlace al informe limpio de caja.
                                 No imprime la pantalla actual, sino una vista preparada para gestor. --}}
                            <a
                                href="{{ route('admin.cash.report', ['date' => $selectedDate]) }}"
                                target="_blank"
                                class="btn-secondary"
                                style="padding: 12px 20px; text-decoration: none;"
                            >
                                INFORME
                            </a>

                            @if ($cashClosure->status === 'closed')
                                <form method="POST" action="{{ route('admin.cash.reopen') }}">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="cash_date" value="{{ $selectedDate }}">

                                    <button
                                        type="submit"
                                        class="btn-primary"
                                        style="padding: 12px 20px;"
                                        onclick="return confirm('¿Seguro que quieres reabrir esta caja? Podrás modificarla de nuevo.')"
                                    >
                                        REABRIR CAJA
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Formulario para añadir movimiento. Solo aparece si la caja está abierta. --}}
                @if ($cashClosure->status === 'open')
                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                        <h2 class="text-terciario" style="margin-bottom: 20px;">
                            AÑADIR MOVIMIENTO
                        </h2>

                        <form method="POST" action="{{ route('admin.cash.movements.store') }}">
                            @csrf

                            {{-- Fecha de la caja en la que se guardará el movimiento --}}
                            <input type="hidden" name="cash_date" value="{{ $selectedDate }}">

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <label class="text-secundario">Tipo *</label>

                                    <select name="type" required style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;">
                                        <option value="income">Ingreso</option>
                                        <option value="expense">Gasto / retirada</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-secundario">Categoría *</label>

                                    <select name="category" required style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;">
                                        <option value="product">Producto</option>
                                        
                                        <option value="withdrawal">Retirada</option>
                                        <option value="adjustment">Otros</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="text-secundario">Método de pago *</label>

                                    <select name="payment_method" required style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;">
                                        <option value="cash">Efectivo</option>
                                        <option value="card">Tarjeta</option>
                                        <option value="other">Otros</option>
                                    </select>
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <label class="text-secundario">Importe *</label>

                                    <input
                                        type="number"
                                        name="amount"
                                        step="0.01"
                                        min="0.01"
                                        required
                                        style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                                    >
                                </div>

                                <div>
                                    <label class="text-secundario">Descripción *</label>

                                    <input
                                        type="text"
                                        name="description"
                                        placeholder="Ej: Agua, barrita, suscripción..."
                                        required
                                        style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                                    >
                                </div>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label class="text-secundario">Notas</label>

                                <textarea
                                    name="notes"
                                    rows="3"
                                    style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                                ></textarea>
                            </div>

                            <button type="submit" class="btn-primary" style="padding: 14px 24px;">
                                GUARDAR MOVIMIENTO
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Tabla de movimientos --}}
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                    <h2 class="text-terciario" style="margin-bottom: 20px;">
                        MOVIMIENTOS DEL DÍA
                    </h2>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                            <thead>
                                <tr style="border-bottom: 1px solid #333;">
                                    <th style="color: #aaa; text-align: left; padding: 12px;">Hora</th>
                                    <th style="color: #aaa; text-align: left; padding: 12px;">Tipo</th>
                                    <th style="color: #aaa; text-align: left; padding: 12px;">Categoría</th>
                                    <th style="color: #aaa; text-align: left; padding: 12px;">Método</th>
                                    <th style="color: #aaa; text-align: left; padding: 12px;">Descripción</th>
                                    <th style="color: #aaa; text-align: right; padding: 12px;">Importe</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($movements as $movement)
                                    <tr style="border-bottom: 1px solid #222;">
                                        <td style="color: #fff; padding: 12px;">
                                            {{ $movement->created_at->format('H:i') }}
                                        </td>

                                        <td style="padding: 12px;">
                                            @if ($movement->type === 'income')
                                                <span style="color: #22c55e; font-weight: bold;">Ingreso</span>
                                            @else
                                                <span style="color: #ef4444; font-weight: bold;">Gasto</span>
                                            @endif
                                        </td>

                                        <td style="color: #fff; padding: 12px;">
                                            {{ $categoryLabels[$movement->category] ?? $movement->category }}
                                        </td>

                                        <td style="color: #fff; padding: 12px;">
                                            {{ $paymentLabels[$movement->payment_method] ?? $movement->payment_method }}
                                        </td>

                                        <td style="color: #fff; padding: 12px;">
                                            {{ $movement->description }}

                                            @if ($movement->notes)
                                                <div style="color: #888; font-size: 12px; margin-top: 4px;">
                                                    {{ $movement->notes }}
                                                </div>
                                            @endif
                                        </td>

                                        <td style="padding: 12px; text-align: right;">
                                            @if ($movement->type === 'income')
                                                <span style="color: #22c55e; font-weight: bold;">
                                                    +{{ number_format($movement->amount, 2) }} €
                                                </span>
                                            @else
                                                <span style="color: #ef4444; font-weight: bold;">
                                                    -{{ number_format($movement->amount, 2) }} €
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="color: #888; text-align: center; padding: 25px;">
                                            Todavía no hay movimientos registrados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Cierre de caja. Solo aparece si la caja está abierta. --}}
                @if ($cashClosure->status === 'open')
                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                        <h2 class="text-terciario" style="margin-bottom: 20px;">
                            CERRAR CAJA
                        </h2>

                        <form method="POST" action="{{ route('admin.cash.close') }}">
                            @csrf
                            @method('PATCH')

                            {{-- Fecha de la caja que se va a cerrar --}}
                            <input type="hidden" name="cash_date" value="{{ $selectedDate }}">

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 20px;">
                                <div>
                                    <label class="text-secundario">Dinero real contado al cerrar *</label>

                                    <input
                                        type="number"
                                        name="closing_amount"
                                        step="0.01"
                                        min="0"
                                        value="{{ number_format($currentBalance, 2, '.', '') }}"
                                        required
                                        style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                                    >
                                </div>

                                <div>
                                    <label class="text-secundario">Observaciones de cierre</label>

                                    <textarea
                                        name="notes"
                                        rows="3"
                                        style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px;"
                                    ></textarea>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="btn-primary"
                                style="padding: 14px 24px; background-color: #dc2626;"
                                onclick="return confirm('¿Seguro que quieres cerrar la caja seleccionada?')"
                            >
                                CERRAR CAJA
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Información cuando la caja está cerrada --}}
                    <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                        <h2 class="text-terciario" style="margin-bottom: 20px;">
                            CAJA CERRADA
                        </h2>

                        <p style="color: #fff;">
                            Importe contado:
                            <strong>{{ number_format($cashClosure->closing_amount, 2) }} €</strong>
                        </p>

                        <p style="color: #fff;">
                            Cerrada el:
                            <strong>{{ $cashClosure->closed_at?->format('d/m/Y H:i') }}</strong>
                        </p>

                        @if ($cashClosure->notes)
                            <p style="color: #aaa;">
                                Observaciones: {{ $cashClosure->notes }}
                            </p>
                        @endif

                        <form method="POST" action="{{ route('admin.cash.reopen') }}" style="margin-top: 20px;">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="cash_date" value="{{ $selectedDate }}">

                            <button
                                type="submit"
                                class="btn-secondary"
                                style="padding: 12px 20px;"
                                onclick="return confirm('¿Seguro que quieres reabrir esta caja? Podrás añadir o corregir movimientos.')"
                            >
                                REABRIR CAJA
                            </button>
                        </form>
                    </div>
                @endif

            @endif
        </div>
    </div>
</x-app-layout>
