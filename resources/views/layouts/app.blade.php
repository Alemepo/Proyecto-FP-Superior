<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Iron Pulse') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="antialiased bg-principal text-secundario min-h-screen flex flex-col">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-principal border-b border-gray-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 anton-text">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="container main-content">
                {{ $slot }}
            </main>

            {{-- Footer general de la web.
                 para que aparezca en todas las páginas internas. --}}
            <footer style="background-color: #050505; border-top: 1px solid #222; padding: 30px 20px; margin-top: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
                    
                    {{-- Logo --}}
                    <div>
                        <a href="{{ url('/') }}" style="text-decoration: none; display: inline-block;">
                            <img src="{{ asset('images/logo/ironPulseTransparente.png') }}" alt="Logo Iron Pulse" style="height: 60px; object-fit: contain;">
                        </a>
                    </div>

                    <style>
                        .footer-link {
                            color: #aaa;
                            text-decoration: none;
                            font-size: 14px;
                            transition: color 0.2s ease, transform 0.2s ease;
                        }

                        .footer-link:hover {
                            color: #ffffff;
                            transform: translateY(-1px);
                        }

                        .footer-link::after {
                            content: '';
                            display: block;
                            width: 0;
                            height: 2px;
                            background: var(--color-terciario);
                            transition: width 0.25s ease;
                        }

                        .footer-link:hover::after {
                            width: 100%;
                        }
                    </style>

                    {{-- Enlaces rápidos --}}
                    <div style="display: flex; gap: 18px; flex-wrap: wrap;">
                       <a href="{{ route('home') }}" class="footer-link">
                            Inicio
                        </a>

                        <a href="{{ route('events.index') }}" class="footer-link">
                            Clases
                        </a>

                        <a href="{{ route('routines.index') }}" class="footer-link">
                            Rutinas
                        </a>


                        <a href="{{ route('plans.index') }}" class="footer-link">
                            Planes
                        </a>

                        <a href="{{ route('dashboard') }}" class="footer-link">
                            QR
                        </a>
                        

                    
                    </div>

                    {{-- Copyright --}}
                    <div style="color: #666; font-size: 13px;">
                        © {{ date('Y') }} Iron Pulse Gym
                    </div>
                </div>
            </footer>
    </body>
</html>