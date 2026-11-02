<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'          => ['required', 'confirmed', Password::defaults()],
            'profile_picture'   => ['nullable', 'image', 'max:2048'],
            'id_type'           => ['required', 'string', 'in:DNI,NIE,Pasaporte'],
            'id_number'         => ['required', 'string', 'max:20'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'birthdate'         => ['required', 'date'],
            'gender'            => ['nullable', 'string', 'in:Masculino,Femenino,Otro'],
            'address'           => ['nullable', 'string', 'max:255'],
            'country'           => ['nullable', 'string', 'max:100'],
            'locality'          => ['nullable', 'string', 'max:100'],
            'province'          => ['nullable', 'string', 'max:100'],
            'postal_code'       => ['nullable', 'string', 'max:10'],
            'emergency_contact' => ['nullable', 'string', 'max:255'],
            'rgpd_consent'      => ['required', 'accepted'],
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'first_name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'last_name.required' => 'Los apellidos son obligatorios.',
            'last_name.max' => 'Los apellidos no pueden tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Introduce un correo electrónico válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'email.max' => 'El correo no puede tener más de 255 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'profile_picture.image' => 'La foto de perfil debe ser un archivo de imagen válido.',
            'profile_picture.max' => 'La foto de perfil no puede superar los 2 MB.',
            'id_type.required' => 'El tipo de documento es obligatorio.',
            'id_type.in' => 'Selecciona un tipo de documento válido.',
            'id_number.required' => 'El número de documento es obligatorio.',
            'id_number.max' => 'El número de documento no puede tener más de 20 caracteres.',
            'birthdate.required' => 'La fecha de nacimiento es obligatoria.',
            'birthdate.date' => 'Introduce una fecha de nacimiento válida.',
            'gender.in' => 'Selecciona un sexo válido.',
            'rgpd_consent.required' => 'Debes aceptar el RGPD para continuar.',
            'rgpd_consent.accepted' => 'Debes aceptar el RGPD para continuar.',
        ]);

        $path = null;
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'name'              => $request->first_name . ' ' . $request->last_name,
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => 'user',
            'profile_picture'   => $path,
            'id_type'           => $request->id_type,
            'id_number'         => $request->id_number,
            'phone'             => $request->phone,
            'birthdate'         => $request->birthdate,
            'gender'            => $request->gender,
            'registration_date' => now()->toDateString(),
            'address'           => $request->address,
            'country'           => $request->country,
            'locality'          => $request->locality,
            'province'          => $request->province,
            'postal_code'       => $request->postal_code,
            'emergency_contact' => $request->emergency_contact,
            'rgpd_consent'      => 1,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}