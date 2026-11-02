<?php

namespace App\Http\Controllers;

use App\Models\CashClosure;
use App\Models\CashMovement;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Muestra el resumen previo al pago de un plan.
     */
    public function showPlanCheckout(Plan $plan)
    {
        return view('stripe.plan-checkout', compact('plan'));
    }

    /**
     * Crea una sesion de Stripe Checkout para el usuario autenticado.
     */
    public function createPlanSession(Request $request, Plan $plan)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para pagar un plan.');
        }

        if (!config('services.stripe.secret') || !config('services.stripe.public')) {
            return redirect()->back()->with('error', 'Stripe no está configurado correctamente.');
        }

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => 'Plan: ' . $plan->name,
                                'description' => $plan->description ?? 'Suscripción al plan ' . $plan->name,
                            ],
                            'unit_amount' => (int) round($plan->price * 100),
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.payment.cancel'),
                'customer_email' => $user->email,
                'client_reference_id' => (string) $user->id,
                'metadata' => [
                    'user_id' => (string) $user->id,
                    'plan_id' => (string) $plan->id,
                    'type' => 'plan_subscription',
                ],
            ]);

            return redirect($session->url);
        } catch (ApiErrorException $e) {
            return redirect()->back()->with('error', 'Error al crear la sesión de pago: ' . $e->getMessage());
        }
    }

    /**
     * Pagina de vuelta desde Stripe. Verifica la sesion antes de activar el plan.
     */
    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
        ]);

        try {
            $session = Session::retrieve($request->session_id);
            $sessionUserId = $this->metadataValue($session->metadata ?? [], 'user_id');

            if ((string) $sessionUserId !== (string) $request->user()->id) {
                abort(403);
            }

            $result = $this->fulfillCheckoutSession($session);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('plans.index')
                ->with('error', 'No hemos podido verificar el pago con Stripe. Si se ha cobrado, contacta con recepcion.');
        }

        return view('stripe.payment-success', [
            'user' => $result['user'],
            'plan' => $result['plan'],
        ]);
    }

    public function paymentCancel()
    {
        return view('stripe.payment-cancel');
    }

    /**
     * Recibe eventos enviados por Stripe.
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature', '');
        $endpointSecret = config('services.stripe.webhook_secret');

        if (! $endpointSecret) {
            Log::warning('Stripe webhook received but STRIPE_WEBHOOK_SECRET is not configured.');

            return response('Webhook secret not configured', 400);
        }

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $signature, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                if (($event->data->object->payment_status ?? null) === 'paid') {
                    $this->fulfillCheckoutSession($event->data->object);
                }
                break;

            case 'checkout.session.async_payment_succeeded':
                $this->fulfillCheckoutSession($event->data->object);
                break;

            case 'checkout.session.async_payment_failed':
                $this->markCheckoutSessionFailed($event->data->object);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Activa el plan y registra el ingreso una sola vez.
     */
    protected function fulfillCheckoutSession($session): array
    {
        if (($session->payment_status ?? null) !== 'paid') {
            throw new \RuntimeException('El pago todavia no ha sido confirmado por Stripe.');
        }

        $metadata = $session->metadata ?? [];
        $user = User::findOrFail($this->metadataValue($metadata, 'user_id'));
        $plan = Plan::findOrFail($this->metadataValue($metadata, 'plan_id'));
        $stripePaymentId = $session->payment_intent ?? $session->id;

        $user->update(['plan_id' => $plan->id]);

        // Solo registrar movimiento si hay una caja abierta para hoy
        $cashClosure = CashClosure::where('cash_date', now()->toDateString())
            ->where('status', 'open')
            ->first();

        $movement = null;
        if ($cashClosure) {
            $movement = CashMovement::firstOrCreate(
                ['stripe_payment_id' => $stripePaymentId],
                [
                    'cash_closure_id' => $cashClosure->id,
                    'user_id' => $user->id,
                    'created_by' => null,
                    'type' => 'income',
                    'category' => 'subscription',
                    'payment_method' => 'stripe',
                    'description' => 'Suscripcion Stripe - Plan ' . $plan->name . ' - ' . $user->name,
                    'amount' => $plan->price,
                    'stripe_status' => 'succeeded',
                    'stripe_metadata' => [
                        'checkout_session_id' => $session->id,
                        'payment_intent' => $session->payment_intent ?? null,
                        'amount_total' => isset($session->amount_total) ? $session->amount_total / 100 : $plan->price,
                        'currency' => $session->currency ?? 'eur',
                        'processed_at' => now()->toDateTimeString(),
                    ],
                ]
            );

            if (!$movement->wasRecentlyCreated && $movement->stripe_status !== 'succeeded') {
                $movement->update(['stripe_status' => 'succeeded']);
            }
        }

        return compact('user', 'plan', 'movement');
    }

    /**
     * Guarda el fallo de un pago asincrono si ya habia movimiento local.
     */
    protected function markCheckoutSessionFailed($session): void
    {
        $stripePaymentId = $session->payment_intent ?? $session->id;
        $movement = CashMovement::where('stripe_payment_id', $stripePaymentId)->first();

        if ($movement) {
            $movement->update([
                'stripe_status' => 'failed',
                'stripe_metadata' => [
                    'checkout_session_id' => $session->id,
                    'payment_intent' => $session->payment_intent ?? null,
                    'failed_at' => now()->toDateTimeString(),
                ],
            ]);

            return;
        }

        Log::warning('Stripe checkout session failed before local movement was created.', [
            'checkout_session_id' => $session->id ?? null,
            'payment_intent' => $session->payment_intent ?? null,
        ]);
    }

    protected function metadataValue($metadata, string $key): ?string
    {
        return is_array($metadata)
            ? ($metadata[$key] ?? null)
            : ($metadata->{$key} ?? null);
    }
}
