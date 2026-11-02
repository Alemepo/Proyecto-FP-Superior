<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Routine;
use App\Models\User;
use App\Models\Plan;
use App\Models\CashClosure;
use App\Models\CashMovement;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    
      //Dashboard principal de administrador.
     
    public function index(): View
    {
        // Seguridad: Solo admins
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        // Mantener solo accesos del día actual.
        // whereDate('entry_time', '<', now()->toDateString()) selecciona registros cuya fecha de entrada sea anterior a hoy.
        AccessLog::whereDate('entry_time', '<', now()->toDateString())->delete();

        $totalUsers = User::count();
        $activeMembers = User::whereNotNull('plan_id')->count();
        $todayAccesses = AccessLog::whereDate('entry_time', now()->toDateString())->count();
        $currentlyInside = AccessLog::whereNull('exit_time')->whereDate('entry_time', now()->toDateString())->count();

        $totalRoutines = Routine::count();
        $totalEvents = Event::count();
        $plans = Plan::all();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'activeMembers' => $activeMembers,
            'todayAccesses' => $todayAccesses,
            'currentlyInside' => $currentlyInside,
            'totalRoutines' => $totalRoutines,
            'totalEvents' => $totalEvents,
            'plans' => $plans,
        ]);
    }

    /*
     * Muestra el formulario para crear una ficha de cliente.
     */
    public function createUser(): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $plans = Plan::all();
        $cashClosure = CashClosure::where('cash_date', now()->toDateString())->first();
        $cajaAbierta = $cashClosure && $cashClosure->status === 'open';

        return view('admin.create-user', [
            'plans' => $plans,
            'cajaAbierta' => $cajaAbierta,
        ]);
    }

    /*
     * Crea un nuevo usuario manualmente.
     */
    public function storeUser(Request $request)
    {
        // Seguridad: Solo admins
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_type' => 'required|string|in:DNI,NIE,Pasaporte',
            'id_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'nullable|string|in:Masculino,Femenino,Otro',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|string|in:cash,card',
            'rgpd_consent' => 'required|accepted',
        ]);

        // Verificar si la caja está abierta
        $cashClosure = CashClosure::where('cash_date', now()->toDateString())->first();

        if (!$cashClosure) {
            return back()->withInput()->with('error', 'Para cobrar el plan físicamente, primero debes abrir la caja de hoy en el panel de Gestión de Caja.');
        }

        if ($cashClosure->status === 'closed') {
            return back()->withInput()->with('error', 'La caja de hoy está cerrada. Reábrela desde la Gestión de Caja para registrar este pago.');
        }

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt('Iron' . substr($request->id_number, -4)),
            'role' => 'user',
            'plan_id' => $request->plan_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'registration_date' => now()->toDateString(),
            'address' => $request->address,
            'country' => $request->country,
            'locality' => $request->locality,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'emergency_contact' => $request->emergency_contact,
            'rgpd_consent' => $request->has('rgpd_consent') ? 1 : 0,
        ]);

        // Registrar pago en caja
        $plan = Plan::find($request->plan_id);
        $cashClosure = CashClosure::where('cash_date', now()->toDateString())->first();

        CashMovement::create([
            'cash_closure_id' => $cashClosure->id,
            'created_by' => Auth::id(),
            'type' => 'income',
            'category' => 'subscription',
            'payment_method' => $request->payment_method,
            'description' => 'Alta de membresía y Plan ' . $plan->name . ' - ' . $user->name,
            'amount' => $plan->price,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra la lista de todos los usuarios registrados y sus planes.
     */
    public function users(Request $request): View
    {
        // Seguridad: Solo admins
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        // Recogemos lo que el admin haya escrito en el buscador
        $search = $request->input('search');

        // Buscamos usuarios. Si hay texto, filtramos; si no, los traemos todos.
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('id', $search);
        })->get();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search // Le pasamos la palabra buscada a la vista para que no se borre del input
        ]);
    }

    /**
     * Muestra la vista para asignar un plan a un usuario existente.
     */
    public function assignPlanView(User $user): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $plans = Plan::all();

        return view('admin.users.assign-plan', [
            'user' => $user,
            'plans' => $plans,
        ]);
    }

    /**
     * Guarda la asignación del plan y registra el pago en caja si corresponde.
     */
    public function assignPlanStore(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required|string|in:cash,card',
        ]);

        // Verificar si la caja está abierta
        $cashClosure = CashClosure::where('cash_date', now()->toDateString())->first();

        if (!$cashClosure) {
            return back()->withInput()->with('error', 'Para cobrar el plan físicamente, primero debes abrir la caja de hoy en el panel de Gestión de Caja.');
        }

        if ($cashClosure->status === 'closed') {
            return back()->withInput()->with('error', 'La caja de hoy está cerrada. Reábrela desde la Gestión de Caja para registrar este pago.');
        }

        $user->update([
            'plan_id' => $request->plan_id,
        ]);

        // Registrar pago en caja
        $plan = Plan::find($request->plan_id);
        
        CashMovement::create([
            'cash_closure_id' => $cashClosure->id,
            'created_by' => Auth::id(),
            'type' => 'income',
            'category' => 'subscription',
            'payment_method' => $request->payment_method,
            'description' => 'Suscripción Plan ' . $plan->name . ' - ' . $user->name,
            'amount' => $plan->price,
        ]);

        return redirect()->route('admin.users')->with('success', 'Plan asignado correctamente.');
    }

    /*
      Muestra la lista de rutinas para que el admin las gestione.
     */
    public function routines(): View
    {
        // Seguridad: Solo admins
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $routines = Routine::all();

        return view('routines.index', [
            'routines' => $routines,
        ]);
    }

    // Muestra la página de la cámara
    public function scanner()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        return view('admin.scanner');
    }

    // Procesa lo que lee la cámara
    public function processScan(Request $request)
    {
        // Mantener solo accesos del día actual
        AccessLog::whereDate('entry_time', '<', now()->toDateString())->delete();

        // Recibimos el texto del QR (ej: "ironpulse-user-5-entry" o "ironpulse-user-5-exit")
        $qrData = $request->input('qr_data');

        // Parseamos el QR para obtener el ID y la acción (entrada o salida)
        $parts = explode('-', $qrData);
        
        // El formato esperado es: ironpulse-user-{id}-{action}
        // Así que $parts[2] es el ID y $parts[3] es la acción
        if (count($parts) < 4) {
            return response()->json([
                'status' => 'error',
                'title' => 'FORMATO INVÁLIDO',
                'message' => 'El código QR no tiene el formato esperado (entrada/salida).',
                'color' => '#ef4444'
            ]);
        }

        $userId = $parts[2];
        $action = $parts[3];

        // Buscamos al usuario en la base de datos
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'title' => 'CÓDIGO INVÁLIDO',
                'message' => 'Este QR no pertenece a ningún usuario registrado.',
                'color' => '#ef4444'
            ]);
        }

        // Comprobamos si tiene plan pagado
        if (!$user->plan_id) {
            return response()->json([
                'status' => 'warning',
                'title' => 'ACCESO DENEGADO',
                'message' => strtoupper($user->name) . ' no tiene ninguna suscripción activa.',
                'color' => '#f59e0b'
            ]);
        }

        $isInside = $user->isInside();

        if ($action === 'entry') {
            if ($isInside) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'YA ESTÁ DENTRO',
                    'message' => strtoupper($user->name) . ' ya tiene un acceso activo. No puede entrar de nuevo.',
                    'color' => '#ef4444'
                ]);
            }

            // Registrar Entrada
            AccessLog::create([
                'user_id' => $user->id,
                'entry_time' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'title' => 'ACCESO CONCEDIDO',
                'message' => 'Bienvenido/a, ' . strtoupper($user->name),
                'color' => '#10b981'
            ]);

        } else if ($action === 'exit') {
            if (!$isInside) {
                return response()->json([
                    'status' => 'error',
                    'title' => 'NO ESTÁ DENTRO',
                    'message' => strtoupper($user->name) . ' no tiene un acceso de entrada registrado.',
                    'color' => '#ef4444'
                ]);
            }

            // Registrar Salida.
            // He añadido whereDate para que solo cierre un acceso abierto de hoy.
            $log = $user->accessLogs()
                ->whereNull('exit_time')
                ->whereDate('entry_time', now()->toDateString())
                ->latest()
                ->first();

            if ($log) {
                $log->update(['exit_time' => now()]);
            }

            return response()->json([
                'status' => 'success',
                'title' => 'SALIDA REGISTRADA',
                'message' => 'Hasta pronto, ' . strtoupper($user->name),
                'color' => '#3b82f6'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'title' => 'ERROR',
            'message' => 'Acción no reconocida en el QR.',
            'color' => '#ef4444'
        ]);
    }

    
     // Muestra la vista "Accesos hoy".
     
    public function todayAccesses(): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        //(ALEX) Borrar accesos anteriores a hoy.
        AccessLog::whereDate('entry_time', '<', now()->toDateString())->delete();

        // get() ejecuta la consulta y devuelve la colección de accesos.
        $accessLogs = AccessLog::with('user')
            ->whereDate('entry_time', now()->toDateString())
            ->orderBy('entry_time', 'asc')
            ->get()
            ->groupBy('user_id');

        // Cuenta registros, no usuarios únicos.
        $totalAccesses = AccessLog::whereDate('entry_time', now()->toDateString())->count();

        // Cargar la nueva vista Blade.
        return view('admin.accesses-today', [
            'accessLogs' => $accessLogs,
            'totalAccesses' => $totalAccesses,
        ]);
    }

    //GESTIÓN DE CLASES (CALENDARIO)

      //Muestra la vista con todas las clases programadas y el formulario para añadir nuevas.
    public function events(): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        // Todos los eventos (clases) ordenados por fecha, desde el más reciente
        $events = Event::orderBy('start_time', 'asc')->get();

        return view('admin.events.index', [
            'events' => $events,
        ]);
    }

    //Guarda una nueva clase en el calendario.
    public function storeEvent(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        // Validación de los datos que envía el formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'capacity' => 'required|integer|min:1',
        ]);

        // Creamos la clase en la base de datos
        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.events')->with('success', 'Clase programada con éxito.');
    }

    //Elimina una clase del calendario.
    public function destroyEvent(Event $event)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $event->delete();

        return redirect()->route('admin.events')->with('success', 'Clase cancelada y eliminada del calendario.');
    }

    // GESTIÓN DE PLANES
    
    //Muestra la vista con todos los planes y precios.
    public function plans(): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $plans = Plan::all();

        return view('admin.plans.index', [
            'plans' => $plans,
        ]);
    }

    //Muestra el formulario para crear un nuevo plan.
    public function createPlan(): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        return view('admin.plans.create');
    }

    //Guarda un nuevo plan en la base de datos.
    public function storePlan(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        Plan::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan creado con éxito.');
    }

    //Muestra el formulario para editar un plan existente.
    public function editPlan(Plan $plan): View
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        return view('admin.plans.edit', [
            'plan' => $plan,
        ]);
    }

    //Actualiza un plan existente en la base de datos.
    public function updatePlan(Request $request, Plan $plan)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan actualizado con éxito.');
    }

    //Elimina un plan de la base de datos.
    public function destroyPlan(Plan $plan)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        // Aqui si queremos comprobar si alguien tine el plan entes de borrarlo se puede hacer tambien 
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan eliminado con éxito.');
    }
}