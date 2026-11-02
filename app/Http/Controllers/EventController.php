<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Horario fijo de clases.
     * Formato:
     *   day: 1 (lunes) a 7 (domingo)
     *   start, end: hora en formato 'H:i'
     *   name: nombre de la clase
     *   capacity: aforo máximo
     */
    private $weeklySchedule = [
        ['day' => 1, 'start' => '11:00', 'end' => '12:00', 'name' => 'Yoga', 'capacity' => 15],
        ['day' => 1, 'start' => '18:30', 'end' => '19:30', 'name' => 'Pilates', 'capacity' => 12],
        ['day' => 2, 'start' => '19:00', 'end' => '20:00', 'name' => 'Boxeo', 'capacity' => 20],
        ['day' => 3, 'start' => '18:00', 'end' => '19:00', 'name' => 'CrossFit', 'capacity' => 20],
        ['day' => 4, 'start' => '20:00', 'end' => '21:00', 'name' => 'Spinning', 'capacity' => 15],
        ['day' => 5, 'start' => '19:30', 'end' => '20:30', 'name' => 'Zumba', 'capacity' => 12],
        ['day' => 6, 'start' => '10:00', 'end' => '11:00', 'name' => 'Yoga', 'capacity' => 15],
        // Añade o modifica según tu horario real
    ];

    /**
     * Genera automáticamente los eventos futuros a partir del horario fijo.
     * Solo crea los que aún no existen en la base de datos.
     *
     * @param int $weeksAhead Cuántas semanas hacia adelante generar
     * @return void
     */
    private function syncEventsForNextWeeks($weeksAhead = 8)
    {
        $today = Carbon::today();
        $endDate = (clone $today)->addWeeks($weeksAhead);
        $startDate = (clone $today)->subWeek(); // también revisa semana anterior por si se añadieron nuevas clases

        foreach ($this->weeklySchedule as $classDef) {
            $dayOfWeek = $classDef['day'];
            $startTime = $classDef['start'];
            $endTime = $classDef['end'];
            $name = $classDef['name'];
            $capacity = $classDef['capacity'];

            $current = clone $startDate;
            while ($current <= $endDate) {
                if ($current->dayOfWeek == $dayOfWeek) {
                    $startDateTime = Carbon::parse($current->toDateString() . ' ' . $startTime);
                    $endDateTime = Carbon::parse($current->toDateString() . ' ' . $endTime);

                    // No crear eventos pasados
                    if ($endDateTime->isPast()) {
                        $current->addDay();
                        continue;
                    }

                    // Evitar duplicados: misma fecha+hora y mismo nombre
                    $exists = Event::where('start_time', $startDateTime)
                        ->where('name', $name)
                        ->exists();

                    if (!$exists) {
                        Event::create([
                            'name' => $name,
                            'start_time' => $startDateTime,
                            'end_time' => $endDateTime,
                            'capacity' => $capacity,
                        ]);
                    }
                }
                $current->addDay();
            }
        }
    }

    /**
     * Muestra el calendario con clases predeterminadas (sincronización automática).
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // Restringir acceso si es usuario normal y no tiene plan
        if ($user->role !== 'admin' && !$user->plan_id) {
            return redirect()->route('plans.index')->with('error', 'Necesitas una membresía activa para acceder al calendario de clases.');
        }

        // Sincronizar eventos para las próximas semanas (esto crea las clases automáticas)
        $this->syncEventsForNextWeeks(8);

        // Obtener eventos ordenados
        $events = Event::with('users')
            ->orderBy('start_time', 'asc')
            ->get()
            ->map(function($event) use ($user) {
                $isPast = Carbon::parse($event->start_time)->isPast();
                $isBooked = $event->users->contains($user->id);
                $isFull = $event->users->count() >= $event->capacity;

                $color = $isPast ? '#444' : ($isBooked ? '#3b82f6' : ($isFull ? '#ef4444' : '#10b981'));
                $status = $isPast ? 'past' : ($isBooked ? 'booked' : ($isFull ? 'full' : 'available'));

                return [
                    'id' => $event->id,
                    'title' => $event->name . ' (' . $event->users->count() . '/' . $event->capacity . ')',
                    'rawName' => $event->name,
                    'start' => $event->start_time,
                    'end' => $event->end_time,
                    'backgroundColor' => 'transparent',
                    'borderColor' => 'transparent',
                    'extendedProps' => [
                        'status' => $status,
                        'isBooked' => $isBooked,
                        'baseColor' => $color
                    ]
                ];
            });

        return view('events.index', [
            'events' => $events,
            'user' => $user
        ]);
    }

    /**
     * Muestra detalles de una clase (opcional, no se usa en el flujo principal).
     */
    public function show(Event $event): View
    {
        $event->loadCount('users');
        return view('events.show', ['event' => $event]);
    }

    /**
     * Reserva una plaza.
     */
    public function reserve(Request $request, Event $event): RedirectResponse
    {
        $user = $request->user();

        if (Carbon::parse($event->start_time)->isPast()) {
            return back()->with('error', 'No puedes apuntarte a una clase que ya ha pasado.');
        }

        if ($user->events()->where('event_id', $event->id)->exists()) {
            return back()->with('warning', 'Ya estás apuntado a esta sesión.');
        }

        if ($event->users()->count() >= $event->capacity) {
            return back()->with('error', 'La clase está llena. No quedan plazas libres.');
        }

        $user->events()->attach($event->id, ['status' => 'confirmed']);
        return back()->with('success', '¡Reserva confirmada! Nos vemos en el box.');
    }

    /**
     * Cancela la reserva.
     */
    public function cancel(Request $request, Event $event): RedirectResponse
    {
        $user = $request->user();
        $user->events()->detach($event->id);
        return back()->with('success', 'Reserva cancelada correctamente. Hemos liberado tu plaza.');
    }

    /**
     * Muestra las clases reservadas por el usuario.
     */
    public function myClasses()
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && !$user->plan_id) {
            return redirect()->route('plans.index')->with('error', 'Necesitas una membresía activa para ver tus reservas.');
        }

        $events = $user->events()
            ->where('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->get();

        return view('events.my-classes', compact('events'));
    }
}