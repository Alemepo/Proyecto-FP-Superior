<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Rellena el usuario con los datos validados (nombre y email)
        $request->user()->fill($request->validated());

        // Si cambia el email, desmarca la verificación
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // --- INICIO CÓDIGO FOTO DE PERFIL ---
        if ($request->hasFile('profile_picture')) {
            // 1. Validamos que sea una imagen real y que no pese más de 2MB
            $request->validate([
                'profile_picture' => ['image', 'max:2048'],
            ]);

            // 2. Guardamos la foto en la carpeta public/profile_pictures
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');

            // 3. Le decimos al usuario que esta es su nueva ruta de imagen
            $request->user()->profile_picture = $path;
        }
        // --- FIN CÓDIGO FOTO DE PERFIL ---

        // Guarda todos los cambios en la base de datos
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
