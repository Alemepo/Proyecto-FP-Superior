<x-app-layout>
    <div class="container" style="padding: 40px 20px; max-width: 1000px;">
        
        <h2 class="anton-text text-secundario" style="font-size: 36px; margin-bottom: 30px;">
            MI <span class="text-terciario">PANEL</span>
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">

            <div style="background-color: #111; border: 2px solid var(--color-terciario); border-radius: 12px; padding: 40px 30px; display: flex; flex-direction: column; align-items: center; text-align: center; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                
                @if(Auth::user()->plan_id)
                    <div style="background-color: var(--color-terciario); color: white; width: 100%; position: absolute; top: 0; left: 0; padding: 8px 0; font-family: var(--font-heading); font-size: 18px; letter-spacing: 2px;">
                        PASE DE ACCESO
                    </div>

                    <div style="margin-top: 20px; margin-bottom: 25px;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=ironpulse-user-{{ Auth::user()->id }}-{{ Auth::user()->isInside() ? 'exit' : 'entry' }}&color=000000&bgcolor=FFFFFF&margin=10" 
                             alt="Código QR de Acceso" 
                             style="border-radius: 8px; width: 180px; height: 180px; box-shadow: 0 0 15px rgba(255,255,255,0.1);">
                        <div style="margin-top: 10px;">
                            <span style="background-color: {{ Auth::user()->isInside() ? '#3b82f6' : '#10b981' }}; color: white; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: bold; letter-spacing: 1px;">
                                QR DE {{ Auth::user()->isInside() ? 'SALIDA' : 'ENTRADA' }}
                            </span>
                        </div>
                    </div>

                    <h3 class="anton-text text-secundario" style="font-size: 28px; margin-bottom: 5px;">
                        {{ strtoupper(Auth::user()->name) }}
                    </h3>
                    <p style="color: #888; font-size: 14px; margin-bottom: 20px; font-weight: bold;">
                        Miembro #{{ Auth::user()->id }}
                    </p>

                    <div style="background-color: rgba(215, 38, 56, 0.1); padding: 8px 24px; border-radius: 50px; font-weight: bold; color: var(--color-terciario); border: 1px solid var(--color-terciario); font-size: 14px;">
                        Escanear en recepción
                    </div>

                @else
                    <div style="background-color: #333; color: #888; width: 100%; position: absolute; top: 0; left: 0; padding: 8px 0; font-family: var(--font-heading); font-size: 18px; letter-spacing: 2px;">
                        ACCESO DENEGADO
                    </div>

                    <div style="margin-top: 30px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; width: 150px; height: 150px; border-radius: 50%; background-color: #222; border: 2px dashed #444;">
                        <x-lucide-lock style="width: 50px; height: 50px; stroke-width: 2; color: #a38a1a;" />
                    </div>

                    <h3 class="anton-text text-secundario" style="font-size: 24px; margin-bottom: 10px;">
                        PASE INACTIVO
                    </h3>
                    <p style="color: #aaa; font-size: 14px; margin-bottom: 25px;">
                        No tienes ninguna suscripción activa. Adquiere un plan para generar tu código QR de acceso.
                    </p>

                    <a href="{{ route('plans.index') }}" class="btn-primary" style="text-decoration: none; border-radius: 6px; width: 100%;">
                        VER PLANES
                    </a>
                @endif

            </div>

            <div style="display: flex; flex-direction: column; gap: 30px;">
                
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                    <h3 class="anton-text text-secundario" style="font-size: 24px; margin-bottom: 15px;">
                        ¡A DARLE CAÑA, {{ explode(' ', strtoupper(Auth::user()->name))[0] }}! <x-lucide-zap style="width: 24px; height: 24px; stroke-width: 2; color: yellow;" />
                    </h3>
                    <p style="color: #aaa; margin-bottom: 0;">
                        Presenta tu código QR en los tornos de la entrada principal para acceder a las instalaciones. El código es único e intransferible y está enlazado a tu cuenta.
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <a href="{{ route('routines.index') }}" style="background-color: #1a1a1a; border: 1px solid #333; padding: 20px; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--color-terciario)'; this.style.backgroundColor='#222'" onmouseout="this.style.borderColor='#333'; this.style.backgroundColor='#1a1a1a'">
                        <div style="color: #fff; font-weight: bold; font-size: 14px;">Mis Rutinas</div>
                    </a>

                    <a href="{{ route('plans.index') }}" style="background-color: #1a1a1a; border: 1px solid #333; padding: 20px; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--color-terciario)'; this.style.backgroundColor='#222'" onmouseout="this.style.borderColor='#333'; this.style.backgroundColor='#1a1a1a'">
                        <div style="color: #fff; font-weight: bold; font-size: 14px;">Mi Plan</div>
                    </a>

                    <a href="{{ route('events.my_classes') }}" style="grid-column: span 2; background-color: #1a1a1a; border: 1px solid #333; padding: 20px; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px;" onmouseover="this.style.borderColor='var(--color-terciario)'; this.style.backgroundColor='#222'; this.style.color='var(--color-terciario)'" onmouseout="this.style.borderColor='#333'; this.style.backgroundColor='#1a1a1a'; this.style.color='#fff'">
                        <x-lucide-calendar-days style="width: 20px; height: 20px; stroke-width: 2; color: currentColor;" />
                        <div style="color: inherit; font-weight: bold; font-size: 14px;">Mis Clases Reservadas</div>
                    </a>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="grid-column: span 2; background-color: rgba(215, 38, 56, 0.1); border: 1px solid var(--color-terciario); padding: 20px; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px;" onmouseover="this.style.backgroundColor='rgba(215, 38, 56, 0.2)'; this.style.color='#fff'" onmouseout="this.style.backgroundColor='rgba(215, 38, 56, 0.1)'; this.style.color='var(--color-terciario)'">
                            <x-lucide-settings style="width: 20px; height: 20px; stroke-width: 2; color: currentColor;" />
                            <div style="color: inherit; font-weight: bold; font-size: 14px;">Acceder al Panel Staff</div>
                        </a>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>