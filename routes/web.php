<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
// Controlador para la gestión de caja diaria
use App\Http\Controllers\CashController;

// 1. VISTA PÚBLICA
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 2. DASHBOARD (Página principal al loguearse)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. RUTAS PROTEGIDAS (Solo para usuarios logueados)
Route::middleware('auth')->group(function () {
    
    // Gestión de Perfil (Breeze + mejora de Foto)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Iron Pulse: Membresías (RF-05)
    Route::get('/planes', [PlanController::class, 'index'])->name('plans.index');
    Route::post('/planes/{plan}/suscribir', [PlanController::class, 'subscribe'])->name('plans.subscribe');
    Route::post('/planes/cancelar', [PlanController::class, 'cancel'])->name('plans.cancel');
    Route::get('/planes/{plan}/exito', [PlanController::class, 'success'])->name('plans.success');

    // Rutas de Iron Pulse: Rutinas (RF-03)
    Route::get('/mis-rutinas', [RoutineController::class, 'index'])->name('routines.index');
    Route::get('/mis-rutinas/crear', [RoutineController::class, 'create'])->name('routines.create');
    Route::post('/mis-rutinas', [RoutineController::class, 'store'])->name('routines.store');
    Route::get('/mis-rutinas/{routine}', [RoutineController::class, 'show'])->name('routines.show');
    Route::get('/mis-rutinas/{routine}/editar', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::put('/mis-rutinas/{routine}', [RoutineController::class, 'update'])->name('routines.update');
    Route::get('/mis-rutinas/{routine}/editar', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::put('/mis-rutinas/{routine}', [RoutineController::class, 'update'])->name('routines.update');
    Route::delete('/mis-rutinas/{routine}', [RoutineController::class, 'destroy'])->name('routines.destroy'); 

    // Rutas de Iron Pulse: Clases y Reservas (RF-04)
    Route::get('/clases', [EventController::class, 'index'])->name('events.index');
    Route::get('/clases/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/clases/{event}/reservar', [EventController::class, 'reserve'])->name('events.reserve');
    Route::delete('/clases/{event}/cancelar', [EventController::class, 'cancel'])->name('events.cancel');
});

// 4. RUTAS DE ADMINISTRACIÓN (Panel de Control Staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/panel-control', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/crear-usuario', [AdminController::class, 'createUser'])->name('admin.create-user');
    Route::post('/panel-control/usuarios', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/usuarios', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/usuarios/{user}/asignar-plan', [AdminController::class, 'assignPlanView'])->name('admin.users.assign-plan');
    Route::post('/usuarios/{user}/asignar-plan', [AdminController::class, 'assignPlanStore'])->name('admin.users.assign-plan.store');
    Route::get('/gestion-rutinas', [AdminController::class, 'routines'])->name('admin.routines');

    // NUEVAS RUTAS DE GESTIÓN DE CLASES (Calendario)
    Route::get('/gestion-clases', [AdminController::class, 'events'])->name('admin.events');
    Route::post('/gestion-clases', [AdminController::class, 'storeEvent'])->name('admin.events.store');
    Route::delete('/gestion-clases/{event}', [AdminController::class, 'destroyEvent'])->name('admin.events.destroy');
    Route::get('/mis-clases', [EventController::class, 'myClasses'])->name('events.my_classes');
    
    // NUEVAS RUTAS DE GESTIÓN DE PLANES
    Route::get('/gestion-planes', [AdminController::class, 'plans'])->name('admin.plans.index');
    Route::get('/gestion-planes/crear', [AdminController::class, 'createPlan'])->name('admin.plans.create');
    Route::post('/gestion-planes', [AdminController::class, 'storePlan'])->name('admin.plans.store');
    Route::get('/gestion-planes/{plan}/editar', [AdminController::class, 'editPlan'])->name('admin.plans.edit');
    Route::put('/gestion-planes/{plan}', [AdminController::class, 'updatePlan'])->name('admin.plans.update');
    Route::delete('/gestion-planes/{plan}', [AdminController::class, 'destroyPlan'])->name('admin.plans.destroy');
    Route::get('/escaner', [AdminController::class, 'scanner'])->name('admin.scanner');
    Route::post('/escaner/procesar', [AdminController::class, 'processScan'])->name('admin.scanner.process');
    // Nueva ruta para mostrar accesos del día
    Route::get('/accesos-hoy', [AdminController::class, 'todayAccesses'])->name('admin.accesses.today');

    //  Rutas de gestión de caja diaria
    Route::get('/admin/caja', [CashController::class, 'index'])->name('admin.cash.index');
    Route::post('/admin/caja/abrir', [CashController::class, 'open'])->name('admin.cash.open');
    Route::post('/admin/caja/movimientos', [CashController::class, 'storeMovement'])->name('admin.cash.movements.store');
    Route::patch('/admin/caja/cerrar', [CashController::class, 'close'])->name('admin.cash.close');
    Route::patch('/admin/caja/reabrir', [CashController::class, 'reopen'])->name('admin.cash.reopen');
    Route::get('/admin/caja/informe', [CashController::class, 'report'])->name('admin.cash.report');
});

// RUTAS DE STRIPE (PAGOS CON TARJETA)

Route::middleware('auth')->group(function () {
    Route::get('/stripe/planes/{plan}/comprar', [StripeController::class, 'showPlanCheckout'])->name('stripe.plan.checkout');
    Route::post('/stripe/planes/{plan}/crear-sesion', [StripeController::class, 'createPlanSession'])->name('stripe.plan.session');
    Route::get('/stripe/pago-exitoso', [StripeController::class, 'paymentSuccess'])->name('stripe.payment.success');
    Route::get('/stripe/pago-cancelado', [StripeController::class, 'paymentCancel'])->name('stripe.payment.cancel');
});

// Webhook de Stripe (sin protección CSRF)
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

// Rutas automáticas de Breeze (Login, Registro, Password Reset...)
require __DIR__.'/auth.php';
