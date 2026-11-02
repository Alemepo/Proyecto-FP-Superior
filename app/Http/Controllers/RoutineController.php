<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoutineController extends Controller
{
    /*
     * Muestra la lista de rutinas del usuario autenticado.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        // Rutinas propias del usuario (no predeterminadas)
        $userRoutines = $user->routines()->where('is_default', false)->wherePivot('is_deleted', false)->get();
        
        // Rutinas predeterminadas no eliminadas por el usuario
        $defaultRoutines = Routine::where('is_default', true)
            ->whereDoesntHave('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('is_deleted', true);
            })
            ->get();
        
        $routines = $userRoutines->merge($defaultRoutines)
            ->unique(function ($routine) {
                return $routine->is_default
                    ? $routine->name . '|' . $routine->gender
                    : 'user-' . $routine->id;
            })
            ->values();
        
        return view('routines.index', [
            'routines' => $routines,
        ]);
    }

    /*
     * Muestra el formulario para crear una nueva rutina.
     */
    public function create(): View
    {
        return view('routines.create');
    }

    /*
     * Almacena una nueva rutina en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dias' => 'nullable|array',
        ]);

        // Limpiar días vacíos y limitar a máximo 7
        $dias = $this->cleanDays($request->dias ?? [], 7);

        $routine = Routine::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'exercises' => $dias,
        ]);

        $request->user()->routines()->attach($routine->id);

        return redirect()->route('routines.index')->with('success', 'Rutina creada');
    }

    /*
     * Muestra los detalles de una rutina específica.
     */
    public function show(Routine $routine): View
    {
        return view('routines.show', [
            'routine' => $routine,
        ]);
    }

    /*
     * Muestra el formulario para editar una rutina.
     */
    public function edit(Routine $routine): View
    {
        return view('routines.edit', [
            'routine' => $routine,
        ]);
    }

    /*
     * Actualiza una rutina en la base de datos.
     */
    public function update(Request $request, Routine $routine): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dias' => 'nullable|array',
        ]);

        // Limpiar días vacíos y limitar a máximo 7
        $dias = $this->cleanDays($request->dias ?? [], 7);

        if ($routine->is_default) {
            // Si es predeterminada, crear una nueva rutina para el usuario
            $newRoutine = Routine::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '',
                'exercises' => $dias,
                'is_default' => false,
                'gender' => null,
            ]);
            
            $request->user()->routines()->attach($newRoutine->id);
            
            // Marcar la predeterminada como eliminada para este usuario
            $request->user()->routines()->syncWithoutDetaching([$routine->id => ['is_deleted' => true]]);
        } else {
            // Actualizar la rutina normal
            $routine->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '',
                'exercises' => $dias,
            ]);
        }

        return redirect()->route('routines.index')->with('success', 'Rutina actualizada');
    }

    /*
     * Limpia días vacíos y ejercicios vacíos, limita a máximo de días.
     */
    private function cleanDays($dias, $maxDays = 7)
    {
        if (!is_array($dias)) {
            return [];
        }

        $cleaned = [];
        $count = 0;

        foreach ($dias as $dia) {
            if ($count >= $maxDays) {
                break;
            }

            if (!is_array($dia)) {
                continue;
            }

            // Limpiar ejercicios vacíos
            $ejercicios = [];
            if (isset($dia['ejercicios']) && is_array($dia['ejercicios'])) {
                foreach ($dia['ejercicios'] as $ejercicio) {
                    if (is_array($ejercicio) && 
                        !empty($ejercicio['nombre']) && 
                        !empty($ejercicio['series']) && 
                        !empty($ejercicio['repeticiones'])) {
                        $ejercicios[] = [
                            'nombre' => trim($ejercicio['nombre']),
                            'series' => trim($ejercicio['series']),
                            'repeticiones' => trim($ejercicio['repeticiones']),
                            'video_url' => trim($ejercicio['video_url'] ?? ''),
                        ];
                    }
                }
            }

            // Solo agregar el día si tiene nombre y al menos un ejercicio
            if (!empty($dia['nombre']) && !empty($ejercicios)) {
                $cleaned[] = [
                    'nombre' => trim($dia['nombre']),
                    'ejercicios' => $ejercicios,
                ];
                $count++;
            }
        }

        return $cleaned;
    }

    /*
     * Elimina una rutina.
     */
    public function destroy(Request $request, Routine $routine): RedirectResponse
    {
        if ($routine->is_default) {
            // Para predeterminadas, marcar como eliminada para este usuario
            $request->user()->routines()->syncWithoutDetaching([$routine->id => ['is_deleted' => true]]);
        } else {
            // Para rutinas propias, eliminar completamente
            $routine->delete();
        }
        
        return redirect()->route('routines.index')
            ->with('success', 'Rutina eliminada exitosamente');
    }
}