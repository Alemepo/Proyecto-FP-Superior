<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Muestra la lista de planes disponibles.
     */
    public function index(): View
    {
        // Obtenemos todos los planes de la base de datos
        $plans = Plan::all();

        return view('plans.index', [
            'plans' => $plans,
        ]);
    }

    /**
     * Suscribe al usuario autenticado a un plan específico.
     */
    public function subscribe(Request $request, Plan $plan): RedirectResponse
    {
        $user = $request->user();

        // Si el plan tiene precio, redirigir a pago con Stripe
        if ($plan->price > 0) {
            return Redirect::route('stripe.plan.checkout', $plan);
        }

        // Si no tiene precio, asignar directamente
        $user->plan_id = $plan->id;
        $user->save();

        return Redirect::route('plans.success', $plan);
    }

    /**
     * Cancela la suscripción actual del usuario.
     */
    public function cancel(Request $request): View
    {
        $user = $request->user();

        // Desvinculamos el plan del usuario (lo dejamos en null)
        $user->plan_id = null;
        $user->save();

        return view('plans.cancel');
    }

    /**
     * Muestra la página de éxito después de suscribirse.
     */
    public function success(Plan $plan): View
    {
        return view('plans.success', compact('plan'));
    }
}