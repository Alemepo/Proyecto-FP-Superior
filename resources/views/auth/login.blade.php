<x-guest-layout>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; background-color: var(--color-principal);">
        
        <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 40px; width: 100%; max-width: 450px; box-shadow: 0 10px 40px rgba(215, 38, 56, 0.15);">
            
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="{{ url('/') }}" class="anton-text" style="font-size: 36px; letter-spacing: 2px; text-decoration: none;">
                    <span class="text-terciario">IRON</span><span class="text-secundario">PULSE</span>
                </a>
                <h2 class="text-secundario" style="margin-top: 10px; font-size: 20px; letter-spacing: 1px;">INICIAR SESIÓN</h2>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label for="email" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Correo Electrónico</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                           style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none;">
                    <x-input-error :messages="$errors->get('email')" style="color: var(--color-terciario); margin-top: 5px; font-size: 14px;" />
                </div>

                <div style="margin-bottom: 25px;">
                    <label for="password" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none;">
                    <x-input-error :messages="$errors->get('password')" style="color: var(--color-terciario); margin-top: 5px; font-size: 14px;" />
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <label for="remember_me" style="display: flex; align-items: center; cursor: pointer;">
                        <input id="remember_me" type="checkbox" name="remember" style="accent-color: var(--color-terciario); cursor: pointer;">
                        <span class="text-secundario" style="margin-left: 8px; font-size: 14px; opacity: 0.8;">Recuérdame</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="color: #888; font-size: 14px; text-decoration: none; transition: color 0.3s;">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <div style="margin-bottom: 20px;">
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; font-size: 18px; border-radius: 6px;">
                        ENTRAR AL ÁREA PERSONAL
                    </button>
                </div>
                
                <div style="text-align: center; border-top: 1px solid #333; padding-top: 20px;">
                    <p style="color: #888; font-size: 14px;">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-terciario" style="font-weight: bold; text-decoration: none;">Regístrate aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>