<nav
    x-data="{ mobileOpen: false }"
    style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; background-color: rgba(0, 0, 0, 0.85); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border-bottom: 5px solid rgba(255, 255, 255, 0.1);"
>
    {{-- Estilos responsive del menú.
         En escritorio se ve el menú normal.
         En móvil se oculta el menú normal y aparece la hamburguesa. --}}
    <style>
        .desktop-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .desktop-menu a,
        .desktop-menu button {
            position: relative;
            transition: color 0.2s ease, transform 0.2s ease, background 0.2s ease;
        }

        .desktop-menu a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background: var(--color-terciario);
            transition: width 0.25s ease;
        }

        .desktop-menu a:hover::after {
            width: 100%;
        }

        .desktop-menu a:hover,
        .desktop-menu button:hover {
            color: #ffffff;
            transform: translateY(-1px);
        }

        .desktop-menu button {
            border: 2px solid var(--color-terciario);
            border-radius: 10px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.05);
        }

        .logo-link {
            display: inline-flex;
            align-items: center;
            transition: transform 0.25s ease, filter 0.25s ease;
        }

        .logo-link:hover {
            transform: scale(1.03);
            filter: brightness(1.1);
        }

        .logo-link img {
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        .logo-link:hover img {
            transform: scale(1.02);
            opacity: 0.95;
        }

        .mobile-menu-button {
            display: none;
            background: #0a0a0a;
            border: 2px solid var(--color-terciario);
            color: #ffffff;
            border-radius: 8px;
            padding: 8px 10px;
            cursor: pointer;
            font-size: 24px;
            line-height: 1;
        }

        .mobile-menu-panel {
            display: none;
        }

        .mobile-menu-panel a,
        .mobile-menu-panel button {
            display: block;
            width: 100%;
            padding: 13px 20px;
            color: #ffffff;
            text-decoration: none;
            font-size: 15px;
            border: none;
            background: transparent;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .mobile-menu-panel a:hover,
        .mobile-menu-panel button:hover {
            background-color: #222222;
        }

        @media (max-width: 900px) {
            .desktop-menu {
                display: none !important;
            }

            .mobile-menu-button {
                display: block;
            }

            .mobile-menu-panel {
                display: block;
                background-color: #111111;
                border-top: 1px solid #333333;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.7);
            }
        }
    </style>

    <div class="container" style="display: flex; justify-content: space-between; align-items: center; height: 80px;">

        {{-- Logo --}}
        <div>
            <a href="{{ url('/') }}" class="anton-text logo-link" style="font-size: 28px; letter-spacing: 2px; text-decoration: none;">
                <img src="{{ asset('images/logo/ironPulseTransparente.png') }}" alt="Logo IronPulse" style="height: 80px; object-fit: contain;">
            </a>
        </div>

        {{-- Menú de escritorio --}}
        <div class="desktop-menu">
            <a href="{{ url('/#quienes-somos') }}" class="text-secundario" style="font-weight: bold; text-decoration: none;">Quiénes somos</a>
            <a href="{{ url('/#clases') }}" class="text-secundario" style="font-weight: bold; text-decoration: none;">Clases</a>
            <a href="{{ url('/#instalaciones') }}" class="text-secundario" style="font-weight: bold; text-decoration: none;">Instalaciones</a>
            <a href="{{ route('routines.index') }}" class="text-secundario" style="font-weight: bold; text-decoration: none;">Rutinas</a>
            <a href="{{ route('plans.index') }}" class="text-secundario" style="font-weight: bold; text-decoration: none;">Planes</a>

            @auth
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" style="position: relative;">

                    <button @click="open = !open" style="display: flex; align-items: center; justify-content: space-between; gap: 12px; background: #0a0a0a; border: 2px solid var(--color-terciario); border-radius: 10px; cursor: pointer; outline: none; padding: 4px 18px 4px 4px; transition: all 0.3s ease;">

                        <div style="width: 42px; height: 42px; border-radius: 50%; overflow: hidden; background-color: #222; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Foto perfil" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="color: #fff; font-weight: bold; font-size: 16px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="text-secundario" style="font-weight: bold; font-size: 15px;">
                                {{ explode(' ', Auth::user()->name)[0] }}
                            </span>

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-terciario)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="display: block; min-width: 20px;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>

                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        style="display: none; position: absolute; right: 0; top: 100%; margin-top: 15px; width: 220px; background-color: #111; border: 1px solid #333; border-radius: 8px; z-index: 50; box-shadow: 0 10px 30px rgba(0,0,0,0.8); overflow: hidden;"
                    >
                        <div style="padding: 5px 0;">

                            <a href="{{ route('dashboard') }}" style="display: block; padding: 12px 20px; color: #fff; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='transparent'">
                                Mi Panel
                            </a>

                            <a href="{{ route('events.index') }}" style="display: block; padding: 12px 20px; color: #fff; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'; this.style.color='var(--color-terciario)'" onmouseout="this.style.background='transparent'; this.style.color='#fff'">
                                Reservar Clase
                            </a>

                            <a href="{{ route('routines.index') }}" style="display: block; padding: 12px 20px; color: #fff; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='transparent'">
                                Mis Rutinas
                            </a>

                            <a href="{{ route('profile.edit') }}" style="display: block; padding: 12px 20px; color: #fff; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='transparent'">
                                Ajustes de Perfil
                            </a>

                            @if(Auth::user()->role === 'admin')
                                <hr style="border: 0; border-top: 1px solid #333; margin: 5px 0;">

                                <div style="padding: 4px 20px; font-size: 11px; color: var(--color-terciario); font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                                    Zona Staff
                                </div>

                                <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 10px 20px; color: #aaa; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'; this.style.color='#fff'" onmouseout="this.style.background='transparent'; this.style.color='#aaa'">
                                    Panel Administrador
                                </a>

                                <a href="{{ route('admin.cash.index') }}" style="display: block; padding: 10px 20px; color: #aaa; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'; this.style.color='#fff'" onmouseout="this.style.background='transparent'; this.style.color='#aaa'">
                                    Gestión de Caja
                                </a>

                                <a href="{{ route('admin.scanner') }}" style="display: block; padding: 10px 20px; color: #aaa; text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#222'; this.style.color='#fff'" onmouseout="this.style.background='transparent'; this.style.color='#aaa'">
                                    Escáner QR
                                </a>
                            @endif

                            <hr style="border: 0; border-top: 1px solid #333; margin: 5px 0;">

                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; text-align: left; padding: 12px 20px; color: var(--color-terciario); font-weight: bold; font-size: 14px; border: none; background: transparent; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='transparent'">
                                    ➜ Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-secundario" style="font-weight: bold; text-decoration: none;">Iniciar Sesión</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary" style="padding: 10px 24px; font-size: 14px; text-decoration: none; border-radius: 6px;">Únete Ahora</a>
                @endif
            @endauth
        </div>

        {{-- Botón hamburguesa móvil --}}
        <button class="mobile-menu-button" @click="mobileOpen = !mobileOpen" aria-label="Abrir menú móvil">
            ☰
        </button>
    </div>

    {{-- Menú móvil desplegable --}}
    <div x-show="mobileOpen" x-transition class="mobile-menu-panel" style="display: none;">
        <a href="{{ url('/#quienes-somos') }}" @click="mobileOpen = false">Quiénes somos</a>
        <a href="{{ url('/#clases') }}" @click="mobileOpen = false">Clases</a>
        <a href="{{ url('/#instalaciones') }}" @click="mobileOpen = false">Instalaciones</a>
        <a href="{{ route('routines.index') }}" @click="mobileOpen = false">Rutinas</a>
        <a href="{{ route('plans.index') }}" @click="mobileOpen = false">Planes</a>

        @auth
            <hr style="border: 0; border-top: 1px solid #333; margin: 5px 20px;">

            <a href="{{ route('dashboard') }}" @click="mobileOpen = false">Mi Panel</a>
            <a href="{{ route('events.index') }}" @click="mobileOpen = false">Reservar Clase</a>
            <a href="{{ route('profile.edit') }}" @click="mobileOpen = false">Ajustes de Perfil</a>

            @if(Auth::user()->role === 'admin')
                <hr style="border: 0; border-top: 1px solid #333; margin: 5px 20px;">

                <div style="padding: 10px 20px 5px 20px; font-size: 11px; color: var(--color-terciario); font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                    Zona Staff
                </div>

                <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false">Panel Administrador</a>
                <a href="{{ route('admin.cash.index') }}" @click="mobileOpen = false">Gestión de Caja</a>
                <a href="{{ route('admin.scanner') }}" @click="mobileOpen = false">Escáner QR</a>
            @endif

            <hr style="border: 0; border-top: 1px solid #333; margin: 5px 20px;">

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="color: var(--color-terciario); font-weight: bold;">
                    ➜ Cerrar Sesión
                </button>
            </form>
        @else
            <hr style="border: 0; border-top: 1px solid #333; margin: 5px 20px;">

            <a href="{{ route('login') }}" @click="mobileOpen = false">Iniciar Sesión</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" @click="mobileOpen = false">Únete Ahora</a>
            @endif
        @endauth
    </div>
</nav>