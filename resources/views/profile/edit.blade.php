<x-app-layout>
    <div class="container" style="padding-top: 120px; padding-bottom: 60px; max-width: 800px;">
        
        <h2 class="anton-text text-secundario" style="font-size: 36px; margin-bottom: 30px;">
            AJUSTES DE <span class="text-terciario">PERFIL</span>
        </h2>

        <div style="display: flex; flex-direction: column; gap: 30px;">

            <section style="background-color: #111; border: 1px solid #333; border-radius: 8px; padding: 30px;">
                <header style="margin-bottom: 20px;">
                    <h3 class="anton-text text-secundario">Información de la Cuenta</h3>
                    <p style="color: #aaa; font-family: var(--font-body);">Actualiza tu nombre, correo y foto de perfil.</p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div style="margin-bottom: 25px;">
                        <label for="profile_picture" style="display: block; font-weight: bold; margin-bottom: 10px; font-family: var(--font-body);">Foto de Perfil</label>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; background-color: #222; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                @if(Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <span class="anton-text text-secundario" style="font-size: 24px;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>
                            <input id="profile_picture" name="profile_picture" type="file" accept="image/*" style="background-color: #000; border: 1px solid #444; border-radius: 6px; padding: 8px; width: 100%; font-family: var(--font-body); color: var(--color-secundario);">
                        </div>
                        <x-input-error class="mt-2 text-terciario" :messages="$errors->get('profile_picture')" />
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="name" style="display: block; font-weight: bold; margin-bottom: 8px; font-family: var(--font-body);">Nombre Completo</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; border-radius: 6px; outline: none; font-family: var(--font-body); color: var(--color-secundario);">
                        <x-input-error class="mt-2 text-terciario" :messages="$errors->get('name')" />
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; font-family: var(--font-body);">Correo Electrónico</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; border-radius: 6px; outline: none; font-family: var(--font-body); color: var(--color-secundario);">
                        <x-input-error class="mt-2 text-terciario" :messages="$errors->get('email')" />
                    </div>

                    <div style="display: flex; align-items: center; gap: 15px;">
                        <button type="submit" class="btn-primary" style="border-radius: 6px;">GUARDAR CAMBIOS</button>
                        @if (session('status') === 'profile-updated')
                            <p style="color: #4ade80; margin: 0; font-weight: bold; font-family: var(--font-body);">✓ Guardado</p>
                        @endif
                    </div>
                </form>
            </section>

            <section style="background-color: #111; border: 1px solid #333; border-radius: 8px; padding: 30px;">
                <header style="margin-bottom: 20px;">
                    <h3 class="anton-text text-secundario">Actualizar Contraseña</h3>
                    <p style="color: #aaa; font-family: var(--font-body);">Asegúrate de usar una contraseña larga y segura.</p>
                </header>

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div style="margin-bottom: 20px;">
                        <label for="update_password_current_password" style="display: block; font-weight: bold; margin-bottom: 8px; font-family: var(--font-body);">Contraseña Actual</label>
                        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; border-radius: 6px; outline: none; font-family: var(--font-body); color: var(--color-secundario);">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-terciario" />
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="update_password_password" style="display: block; font-weight: bold; margin-bottom: 8px; font-family: var(--font-body);">Nueva Contraseña</label>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password" style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; border-radius: 6px; outline: none; font-family: var(--font-body); color: var(--color-secundario);">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-terciario" />
                    </div>

                    <div style="margin-bottom: 25px;">
                        <label for="update_password_password_confirmation" style="display: block; font-weight: bold; margin-bottom: 8px; font-family: var(--font-body);">Confirmar Nueva Contraseña</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; border-radius: 6px; outline: none; font-family: var(--font-body); color: var(--color-secundario);">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-terciario" />
                    </div>

                    <div style="display: flex; align-items: center; gap: 15px;">
                        <button type="submit" class="btn-primary" style="border-radius: 6px;">ACTUALIZAR CONTRASEÑA</button>
                        @if (session('status') === 'password-updated')
                            <p style="color: #4ade80; margin: 0; font-weight: bold; font-family: var(--font-body);">✓ Actualizada</p>
                        @endif
                    </div>
                </form>
            </section>

            <section style="background-color: #111; border: 1px solid #333; border-left: 4px solid var(--color-terciario); border-radius: 8px; padding: 30px;">
                <header style="margin-bottom: 20px;">
                    <h3 class="anton-text text-secundario">Eliminar Cuenta</h3>
                    <p style="color: #aaa; font-family: var(--font-body);">Una vez que se elimine tu cuenta, todos tus recursos y datos se borrarán permanentemente.</p>
                </header>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; font-weight: bold; margin-bottom: 8px; font-family: var(--font-body);">Contraseña para confirmar</label>
                        <input id="password" name="password" type="password" placeholder="Ingresa tu contraseña" style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; border-radius: 6px; outline: none; font-family: var(--font-body); color: var(--color-secundario);">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-terciario" />
                    </div>

                    <button type="submit" class="btn-secondary" style="border-radius: 6px; border-color: var(--color-terciario); color: var(--color-terciario);" onmouseover="this.style.backgroundColor='var(--color-terciario)'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--color-terciario)';">
                        ELIMINAR DEFINITIVAMENTE
                    </button>
                </form>
            </section>

        </div>
    </div>
</x-app-layout>