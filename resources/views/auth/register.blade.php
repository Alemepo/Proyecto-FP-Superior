<x-guest-layout>
    <div style="display: flex; justify-content: center; align-items: flex-start; min-height: 100vh; padding: 40px 20px; background-color: var(--color-principal);">
        
        <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 40px; width: 100%; max-width: 800px; box-shadow: 0 10px 40px rgba(215, 38, 56, 0.15);">
            
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="{{ url('/') }}" class="anton-text" style="font-size: 36px; letter-spacing: 2px; text-decoration: none;">
                    <span class="text-terciario">IRON</span><span class="text-secundario">PULSE</span>
                </a>
                <h2 class="text-secundario" style="margin-top: 10px; font-size: 20px; letter-spacing: 1px;">CREAR CUENTA</h2>
            </div>

            {{-- Añadimos novalidate para que el navegador no bloquee los mensajes de Laravel --}}
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- RESUMEN DE ERRORES (Opcional, pero útil) --}}
                @if ($errors->any())
                    <div id="register-errors-summary" style="background: rgba(215, 38, 56, 0.18); border: 1px solid #D72638; color: #fff; padding: 16px; border-radius: 10px; margin-bottom: 24px;">
                        <strong style="display:block; margin-bottom: 5px;">Revisa los campos marcados en rojo:</strong>
                    </div>
                @endif

                {{-- DATOS DE ACCESO --}}
                <h3 style="color: #fff; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px;">Datos de Acceso</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label for="email" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Correo Electrónico *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('email') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('email') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="profile_picture" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Foto de Perfil (Opcional)</label>
                        <input id="profile_picture" type="file" name="profile_picture" accept="image/*"
                               style="width: 100%; padding: 10px; background-color: #000; border: 1px solid {{ $errors->has('profile_picture') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box; font-size: 14px;">
                        @error('profile_picture') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Contraseña *</label>
                        <input id="password" type="password" name="password" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('password') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('password') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Confirmar Contraseña *</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                {{-- DATOS PERSONALES --}}
                <h3 style="color: #fff; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px;">Datos Personales</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label for="first_name" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Nombre *</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('first_name') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('first_name') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="last_name" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Apellidos *</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('last_name') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('last_name') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="id_type" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Tipo de Documento *</label>
                        <select id="id_type" name="id_type" required
                                style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('id_type') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                            <option value="">Seleccionar</option>
                            <option value="DNI" {{ old('id_type') == 'DNI' ? 'selected' : '' }}>DNI</option>
                            <option value="NIE" {{ old('id_type') == 'NIE' ? 'selected' : '' }}>NIE</option>
                            <option value="Pasaporte" {{ old('id_type') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                        </select>
                        @error('id_type') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="id_number" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Número de Documento *</label>
                        <input id="id_number" type="text" name="id_number" value="{{ old('id_number') }}" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('id_number') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('id_number') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Teléfono</label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('phone') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('phone') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="birthdate" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Fecha de Nacimiento *</label>
                        <input id="birthdate" type="date" name="birthdate" value="{{ old('birthdate') }}" required
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('birthdate') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box; color-scheme: dark;">
                        @error('birthdate') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="gender" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Sexo</label>
                        <select id="gender" name="gender"
                                style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('gender') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                            <option value="">Seleccionar</option>
                            <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('gender') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('gender') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- DIRECCIÓN --}}
                <h3 style="color: #fff; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px;">Dirección</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="grid-column: 1 / -1;">
                        <label for="address" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Dirección</label>
                        <input id="address" type="text" name="address" value="{{ old('address') }}"
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('address') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('address') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="country" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">País</label>
                        <input id="country" type="text" name="country" value="{{ old('country') }}"
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('country') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('country') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="locality" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Localidad</label>
                        <input id="locality" type="text" name="locality" value="{{ old('locality') }}"
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('locality') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('locality') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="province" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Provincia</label>
                        <input id="province" type="text" name="province" value="{{ old('province') }}"
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('province') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('province') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="postal_code" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Código Postal</label>
                        <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}"
                               style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('postal_code') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                        @error('postal_code') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- CONTACTO DE EMERGENCIA --}}
                <h3 style="color: #fff; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px;">Contacto de Emergencia</h3>
                <div style="margin-bottom: 30px;">
                    <label for="emergency_contact" class="text-secundario" style="display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px;">Nombre y Teléfono</label>
                    <input id="emergency_contact" type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="Ej: María García - 600 000 000"
                           style="width: 100%; padding: 12px; background-color: #000; border: 1px solid {{ $errors->has('emergency_contact') ? '#D72638' : '#444' }}; color: #fff; border-radius: 6px; outline: none; box-sizing: border-box;">
                    @error('emergency_contact') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span> @enderror
                </div>

                {{-- RGPD --}}
                <div style="margin-bottom: 30px; background-color: #1a1a1a; padding: 20px; border-radius: 8px; border-left: 4px solid {{ $errors->has('rgpd_consent') ? '#D72638' : 'var(--color-terciario)' }};">
                    <label style="color: #aaa; display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                        <input type="checkbox" id="rgpd_consent" name="rgpd_consent" required style="width: 20px; height: 20px; margin-top: 2px; flex-shrink: 0;">
                        <span style="font-size: 14px; line-height: 1.5;">Acepto el tratamiento de mis datos personales según la política de privacidad y el Reglamento General de Protección de Datos (RGPD). *</span>
                    </label>
                    @error('rgpd_consent') <span style="color: #D72638; font-size: 13px; display: block; margin-top: 5px;">Debe aceptar la política de datos.</span> @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; font-size: 18px; border-radius: 6px; background-color: #D72638; color: #fff; border: none; cursor: pointer; font-weight: bold;">
                        CREAR CUENTA
                    </button>
                </div>
                
                <div style="text-align: center; border-top: 1px solid #333; padding-top: 20px;">
                    <p style="color: #888; font-size: 14px;">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-terciario" style="font-weight: bold; text-decoration: none; color: #D72638;">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    {{-- Script para mover la pantalla al primer error si lo hay --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const firstError = document.querySelector('[style*="#D72638"]');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        </script>
    @endif
</x-guest-layout>