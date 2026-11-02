<?php

namespace App\Http\Controllers;

use App\Models\CashClosure;
use App\Models\CashMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    /*
     * Muestra la pantalla principal de caja.
    */
    
    
    public function index(Request $request)
    {
        // Fecha seleccionada desde el calendario. Si no llega ninguna, usamos hoy.
        $selectedDate = $request->input('date', now()->toDateString());

        // Caja correspondiente a la fecha seleccionada.
        $cashClosure = CashClosure::where('cash_date', $selectedDate)
            ->with(['movements.user', 'movements.createdBy'])
            ->first();

        // Historial rápido de las últimas cajas creadas.
        $cashClosures = CashClosure::orderByDesc('cash_date')
            ->take(20)
            ->get();

        // Valores por defecto si no existe caja para esa fecha.
        $movements = collect();

        $totalIncome = 0;
        $totalExpense = 0;
        $cashIncome = 0;
        $cardIncome = 0;
        $stripeIncome = 0;
        $otherIncome = 0;

        if ($cashClosure) {
            // Movimientos de la caja seleccionada.
            $movements = $cashClosure->movements()
                ->latest()
                ->get();

            // Total de ingresos.
            $totalIncome = $cashClosure->movements()
                ->where('type', 'income')
                ->sum('amount');

            // Total de gastos o retiradas.
            $totalExpense = $cashClosure->movements()
                ->where('type', 'expense')
                ->sum('amount');

            // Ingresos en efectivo.
            $cashIncome = $cashClosure->movements()
                ->where('type', 'income')
                ->where('payment_method', 'cash')
                ->sum('amount');

            // Ingresos con tarjeta.
            $cardIncome = $cashClosure->movements()
                ->where('type', 'income')
                ->where('payment_method', 'card')
                ->sum('amount');

            $stripeIncome = $cashClosure->movements()
                ->where('type', 'income')
                ->where('payment_method', 'stripe')
                ->sum('amount');

            // Ingresos en otros métodos de pago.
            $otherIncome = $cashClosure->movements()
                ->where('type', 'income')
                ->where('payment_method', 'other')
                ->sum('amount');
        }

        // Saldo calculado: apertura + ingresos - gastos.
        $currentBalance = $cashClosure
            ? $cashClosure->opening_amount + $totalIncome - $totalExpense
            : 0;

        return view('admin.cash.index', compact(
            'selectedDate',
            'cashClosure',
            'cashClosures',
            'movements',
            'totalIncome',
            'totalExpense',
            'cashIncome',
            'cardIncome',
            'stripeIncome',
            'otherIncome',
            'currentBalance'
        ));
    }

    /*
     Abre una caja para la fecha seleccionada.
     */
     
    public function open(Request $request)
    {
        $request->validate([
            'cash_date' => ['required', 'date'],
            'opening_amount' => ['required', 'numeric', 'min:0'],
        ]);

        // Evitamos duplicar cajas en la misma fecha.
        $existingCashClosure = CashClosure::where('cash_date', $request->cash_date)->first();

        if ($existingCashClosure) {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'Ya existe una caja creada para esa fecha.');
        }

        CashClosure::create([
            'cash_date' => $request->cash_date,
            'opening_amount' => $request->opening_amount,
            'status' => 'open',
            'opened_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.cash.index', ['date' => $request->cash_date])
            ->with('success', 'Caja abierta correctamente.');
    }

    /**
     
     * Categorías permitidas:
     
     * Métodos de pago permitidos:
     
     */
    public function storeMovement(Request $request)
    {
        $request->validate([
            'cash_date' => ['required', 'date'],
            'type' => ['required', 'in:income,expense'],

            
            'category' => ['required', 'in:product,withdrawal,adjustment'],

            // Métodos de pago permitidos: efectivo, tarjeta y otros.
            'payment_method' => ['required', 'in:cash,card,other'],

            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string'],
        ]);

        $cashClosure = CashClosure::where('cash_date', $request->cash_date)->first();

        if (!$cashClosure) {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'Primero debes abrir la caja de esa fecha.');
        }

        if ($cashClosure->status === 'closed') {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'La caja de esa fecha está cerrada. Debes reabrirla para modificarla.');
        }

        CashMovement::create([
            'cash_closure_id' => $cashClosure->id,
            'created_by' => Auth::id(),
            'type' => $request->type,
            'category' => $request->category,
            'payment_method' => $request->payment_method,
            'description' => $request->description,
            'amount' => $request->amount,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('admin.cash.index', ['date' => $request->cash_date])
            ->with('success', 'Movimiento registrado correctamente.');
    }

    /*
    Cierra la caja seleccionada.
     */
    
    
     
    public function close(Request $request)
    {
        $request->validate([
            'cash_date' => ['required', 'date'],
            'closing_amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $cashClosure = CashClosure::where('cash_date', $request->cash_date)->first();

        if (!$cashClosure) {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'No hay caja abierta para esa fecha.');
        }

        if ($cashClosure->status === 'closed') {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'La caja ya está cerrada.');
        }

        $cashClosure->update([
            'closing_amount' => $request->closing_amount,
            'status' => 'closed',
            'closed_by' => Auth::id(),
            'closed_at' => now(),
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('admin.cash.index', ['date' => $request->cash_date])
            ->with('success', 'Caja cerrada correctamente.');
    }

    /*
      Reabre una caja cerrada.
     
     */
    public function reopen(Request $request)
    {
        $request->validate([
            'cash_date' => ['required', 'date'],
        ]);

        $cashClosure = CashClosure::where('cash_date', $request->cash_date)->first();

        if (!$cashClosure) {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'No existe caja para esa fecha.');
        }

        if ($cashClosure->status === 'open') {
            return redirect()
                ->route('admin.cash.index', ['date' => $request->cash_date])
                ->with('error', 'La caja ya está abierta.');
        }

        $cashClosure->update([
            'status' => 'open',
            'closing_amount' => null,
            'closed_by' => null,
            'closed_at' => null,
        ]);

        return redirect()
            ->route('admin.cash.index', ['date' => $request->cash_date])
            ->with('success', 'Caja reabierta correctamente.');
    }

    /*
      Muestra un informe limpio de caja para imprimir o guardar como PDF.
    
     */
    public function report(Request $request)
    {
        // Fecha del informe. Si no llega ninguna fecha, usamos hoy.
        $selectedDate = $request->input('date', now()->toDateString());

        // Buscamos la caja de la fecha seleccionada con sus movimientos.
        $cashClosure = CashClosure::where('cash_date', $selectedDate)
            ->with(['movements.user', 'movements.createdBy'])
            ->first();

        // Si no existe caja para esa fecha, volvemos a la pantalla de caja.
        if (!$cashClosure) {
            return redirect()
                ->route('admin.cash.index', ['date' => $selectedDate])
                ->with('error', 'No existe una caja para generar el informe de esa fecha.');
        }

        // Movimientos del día ordenados de más antiguo a más reciente.
        $movements = $cashClosure->movements()
            ->oldest()
            ->get();

        // Total de ingresos.
        $totalIncome = $cashClosure->movements()
            ->where('type', 'income')
            ->sum('amount');

        // Total de gastos o retiradas.
        $totalExpense = $cashClosure->movements()
            ->where('type', 'expense')
            ->sum('amount');

        // Totales por método de pago.
        $cashIncome = $cashClosure->movements()
            ->where('type', 'income')
            ->where('payment_method', 'cash')
            ->sum('amount');

        $cardIncome = $cashClosure->movements()
            ->where('type', 'income')
            ->where('payment_method', 'card')
            ->sum('amount');

        $stripeIncome = $cashClosure->movements()
            ->where('type', 'income')
            ->where('payment_method', 'stripe')
            ->sum('amount');

        $otherIncome = $cashClosure->movements()
            ->where('type', 'income')
            ->where('payment_method', 'other')
            ->sum('amount');

        // Saldo calculado por el sistema.
        $calculatedBalance = $cashClosure->opening_amount + $totalIncome - $totalExpense;

        // Diferencia entre lo que debería haber y lo contado al cerrar.
        $cashDifference = null;

        if (!is_null($cashClosure->closing_amount)) {
            $cashDifference = $cashClosure->closing_amount - $calculatedBalance;
        }

        return view('admin.cash.report', compact(
            'selectedDate',
            'cashClosure',
            'movements',
            'totalIncome',
            'totalExpense',
            'cashIncome',
            'cardIncome',
            'stripeIncome',
            'otherIncome',
            'calculatedBalance',
            'cashDifference'
        ));
    }
}
