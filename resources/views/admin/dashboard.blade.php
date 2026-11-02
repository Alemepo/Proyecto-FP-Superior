<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 class="anton-text text-secundario" style="margin-bottom: 5px;">
                    PANEL DE <span class="text-terciario">CONTROL</span>
                </h2>
                <p style="color: #888; margin: 0;">Visión general del gimnasio Iron Pulse</p>
            </div>
            
            <a href="{{ route('admin.scanner') }}" class="btn-primary" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <x-lucide-camera style="width: 20px; height: 20px; stroke-width: 2; color: currentColor;" />
                ABRIR ESCÁNER
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
            
            <!-- Total Usuarios -->
            <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #666; border-radius: 10px; padding: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: #aaa; text-transform: uppercase; font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-bottom: 5px;">Total Usuarios</p>
                        <h3 class="anton-text text-secundario" style="font-size: 40px; margin: 0;">{{ $totalUsers }}</h3>
                    </div>
                    <div style="background-color: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 8px;">
                        <x-lucide-users style="width: 24px; height: 24px; stroke-width: 2; color: #aaa;" />
                    </div>
                </div>
            </div>

            <!-- Socios Activos -->
            <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #10b981; border-radius: 10px; padding: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: #aaa; text-transform: uppercase; font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-bottom: 5px;">Socios Activos</p>
                        <h3 class="anton-text text-secundario" style="font-size: 40px; margin: 0;">{{ $activeMembers }}</h3>
                    </div>
                    <div style="background-color: rgba(16, 185, 129, 0.1); padding: 12px; border-radius: 8px;">
                        <x-lucide-star style="width: 24px; height: 24px; stroke-width: 2; color: #10b981;" />
                    </div>
                </div>
            </div>

            <!-- Accesos Hoy -->
            <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #3b82f6; border-radius: 10px; padding: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: #aaa; text-transform: uppercase; font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-bottom: 5px;">Accesos Hoy</p>
                        <h3 class="anton-text text-secundario" style="font-size: 40px; margin: 0;">{{ $todayAccesses }}</h3>
                    </div>
                    <div style="background-color: rgba(59, 130, 246, 0.1); padding: 12px; border-radius: 8px;">
                        <x-lucide-log-in style="width: 24px; height: 24px; stroke-width: 2; color: #3b82f6;" />
                    </div>
                </div>
            </div>

            <!-- Personas Dentro -->
            <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid var(--color-terciario); border-radius: 10px; padding: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: #aaa; text-transform: uppercase; font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-bottom: 5px;">Personas Dentro</p>
                        <h3 class="anton-text text-secundario" style="font-size: 40px; margin: 0;">{{ $currentlyInside }}</h3>
                    </div>
                    <div style="background-color: rgba(215, 38, 56, 0.1); padding: 12px; border-radius: 8px;">
                        <x-lucide-user-check style="width: 24px; height: 24px; stroke-width: 2; color: var(--color-terciario);" />
                    </div>
                </div>
            </div>

            <!-- Rutinas Creadas -->
            <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #f59e0b; border-radius: 10px; padding: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: #aaa; text-transform: uppercase; font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-bottom: 5px;">Rutinas Creadas</p>
                        <h3 class="anton-text text-secundario" style="font-size: 40px; margin: 0;">{{ $totalRoutines }}</h3>
                    </div>
                    <div style="background-color: rgba(245, 158, 11, 0.1); padding: 12px; border-radius: 8px;">
                        <x-lucide-dumbbell style="width: 24px; height: 24px; stroke-width: 2; color: #f59e0b;" />
                    </div>
                </div>
            </div>

            <!-- Clases Programadas -->
            <div style="background-color: #111; border: 1px solid #333; border-top: 4px solid #8b5cf6; border-radius: 10px; padding: 25px; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="color: #aaa; text-transform: uppercase; font-weight: bold; font-size: 12px; letter-spacing: 1px; margin-bottom: 5px;">Clases Programadas</p>
                        <h3 class="anton-text text-secundario" style="font-size: 40px; margin: 0;">{{ $totalEvents }}</h3>
                    </div>
                    <div style="background-color: rgba(139, 92, 246, 0.1); padding: 12px; border-radius: 8px;">
                        <x-lucide-calendar-days style="width: 24px; height: 24px; stroke-width: 2; color: #8b5cf6;" />
                    </div>
                </div>
            </div>

        </div>

        <h3 class="anton-text text-secundario" style="margin-bottom: 20px;">ACCESOS <span class="text-terciario">RÁPIDOS</span></h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            
            <a href="{{ route('admin.accesses.today') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                {{-- NUEVO: Icono visual de entrada/acceso. --}}
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-log-in style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>

                {{-- NUEVO: Texto visible de la tarjeta. --}}
                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Accesos hoy</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Ver entradas del día por usuario.</p>
                </div>
            </a>

            <a href="{{ route('admin.users') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-user style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>
                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Gestionar Usuarios</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Ver miembros y suscripciones.</p>
                </div>
            </a>

            <a href="{{ route('admin.routines') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-dumbbell style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>
                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Gestionar Rutinas</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Revisar entrenamientos creados.</p>
                </div>
            </a>

            <a href="{{ route('admin.events') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-calendar-days style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>
                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Gestionar Clases</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Añadir sesiones al calendario.</p>
                </div>
            </a>

            <a href="{{ route('admin.create-user') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-notebook style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>
                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Crear Ficha de Cliente</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Registrar nuevo miembro con datos completos.</p>
                </div>
            </a>

            {{-- Acceso rápido a la gestión diaria de caja --}}
            <a href="{{ route('admin.cash.index') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-hand-coins style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>

                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Gestión de Caja</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Registrar ingresos, gastos y cierre diario.</p>
                </div>
            </a>

            <a href="{{ route('admin.plans.index') }}" style="background-color: #0a0a0a; border: 1px solid #333; border-radius: 10px; padding: 20px; text-decoration: none; display: flex; align-items: center; gap: 15px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#111'" onmouseout="this.style.backgroundColor='#0a0a0a'">
                <div style="background-color: #222; padding: 10px; border-radius: 8px;">
                    <x-lucide-chart-gantt style="width: 24px; height: 24px; stroke-width: 2; color: currentColor;" />
                </div>
                <div>
                    <h4 class="text-secundario" style="margin: 0; font-size: 18px;">Gestionar Planes</h4>
                    <p style="color: #888; margin: 0; font-size: 13px;">Modificar precios y suscripciones.</p>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>