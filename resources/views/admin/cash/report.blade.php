<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de caja</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111;
            margin: 30px;
            font-size: 14px;
        }

        .actions {
            text-align: right;
            margin-bottom: 20px;
        }

        .actions a,
        .actions button {
            background: #111;
            color: #fff;
            border: 0;
            padding: 9px 14px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
        }

        h1 {
            margin-bottom: 5px;
        }

        .muted {
            color: #666;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 25px 0;
        }

        .box {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 6px;
        }

        .label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }

        .amount {
            font-size: 20px;
            font-weight: bold;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #111;
            color: #fff;
            text-align: left;
            padding: 8px;
        }

        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        .right {
            text-align: right;
        }

        .green {
            color: #15803d;
            font-weight: bold;
        }

        .red {
            color: #b91c1c;
            font-weight: bold;
        }

        .note {
            margin-top: 25px;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 6px;
        }

        @media print {
            .actions {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    @php
        // Traducciones para que no aparezcan valores internos en inglés.
        $categoryLabels = [
            'subscription' => 'Suscripción',
            'product' => 'Producto',
            'manual' => 'Manual',
            'withdrawal' => 'Retirada',
            'adjustment' => 'Ajuste',
        ];

        $paymentLabels = [
            'cash' => 'Efectivo',
            'card' => 'Tarjeta',
            'stripe' => 'Stripe',
            'transfer' => 'Transferencia',
            'other' => 'Otro',
        ];
    @endphp

    {{-- Botones solo visibles en pantalla --}}
    <div class="actions">
        <a href="{{ route('admin.cash.index', ['date' => $selectedDate]) }}">Volver</a>
        <button onclick="window.print()">Imprimir / PDF</button>
    </div>

    <h1>Informe de caja</h1>

    <p class="muted">
        Iron Pulse Gym ·
        Fecha: <strong>{{ $cashClosure->cash_date->format('d/m/Y') }}</strong> ·
        Estado: <strong>{{ $cashClosure->status === 'open' ? 'Abierta' : 'Cerrada' }}</strong>
    </p>

    {{-- Resumen de dinero --}}
    <div class="summary">
        <div class="box">
            <div class="label">Apertura</div>
            <div class="amount">{{ number_format($cashClosure->opening_amount, 2) }} €</div>
        </div>

        <div class="box">
            <div class="label">Ingresos</div>
            <div class="amount green">{{ number_format($totalIncome, 2) }} €</div>
        </div>

        <div class="box">
            <div class="label">Gastos</div>
            <div class="amount red">{{ number_format($totalExpense, 2) }} €</div>
        </div>

        <div class="box">
            <div class="label">Saldo</div>
            <div class="amount">{{ number_format($calculatedBalance, 2) }} €</div>
        </div>
    </div>

    {{-- Movimientos de caja --}}
    <h2>Movimientos</h2>

    <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Categoría</th>
                <th>Método</th>
                <th>Concepto</th>
                <th class="right">Importe</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($movements as $movement)
                <tr>
                    <td>{{ $movement->created_at->format('H:i') }}</td>

                    <td>
                        @if ($movement->type === 'income')
                            <span class="green">Ingreso</span>
                        @else
                            <span class="red">Gasto</span>
                        @endif
                    </td>

                    <td>{{ $categoryLabels[$movement->category] ?? $movement->category }}</td>
                    <td>{{ $paymentLabels[$movement->payment_method] ?? $movement->payment_method }}</td>

                    <td>
                        {{ $movement->description }}

                        @if ($movement->notes)
                            <br>
                            <small class="muted">{{ $movement->notes }}</small>
                        @endif
                    </td>

                    <td class="right">
                        @if ($movement->type === 'income')
                            <span class="green">+{{ number_format($movement->amount, 2) }} €</span>
                        @else
                            <span class="red">-{{ number_format($movement->amount, 2) }} €</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay movimientos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Observaciones si existen --}}
    @if ($cashClosure->notes)
        <div class="note">
            <strong>Observaciones:</strong>
            {{ $cashClosure->notes }}
        </div>
    @endif
</body>
</html>
