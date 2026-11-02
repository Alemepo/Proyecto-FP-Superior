<x-app-layout>
    <section id="quienes-somos" class="container" style="padding-top: 100px; padding-bottom: 80px;">
        <div class="grid" style="align-items: center; min-height: 60vh; display: grid; grid-template-columns: repeat(12, 1fr); gap: 30px;">
            
            <div style="grid-column: span 6;">
                <h1 class="anton-text text-secundario" style="font-size: 4.5rem; line-height: 1.1; margin-bottom: 1.5rem; text-transform: uppercase;">
                    Domina tu <br>
                    <span class="text-terciario">Potencial</span>
                </h1>
                
                <p class="text-secundario" style="font-size: 1.2rem; margin-bottom: 2.5rem; opacity: 0.9; max-width: 90%; line-height: 1.6;">
                    Bienvenido a <strong>Iron Pulse</strong>. Más que un gimnasio, somos una comunidad forjada en hierro y disciplina. Entrena con el mejor equipamiento y rompe tus límites hoy mismo.
                </p>
                
                <div style="display: flex; gap: 20px;">
                    @auth
                        @if(Auth::user()->plan_id)
                            <a href="{{ route('events.index') }}" class="btn-primary" style="text-decoration: none; padding: 15px 30px; font-weight: bold; text-transform: uppercase;">Reservar Clase</a>
                        @else
                            <a href="{{ route('plans.index') }}" class="btn-primary" style="text-decoration: none; padding: 15px 30px; font-weight: bold; text-transform: uppercase;">Ver Planes</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="btn-secondary" style="text-decoration: none; padding: 15px 30px; font-weight: bold; text-transform: uppercase;">Mi Panel</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary" style="text-decoration: none; padding: 15px 30px; font-weight: bold; text-transform: uppercase;">Únete ahora</a>
                        <a href="{{ route('plans.index') }}" class="btn-secondary" style="text-decoration: none; padding: 15px 30px; font-weight: bold; text-transform: uppercase;">Ver Planes</a>
                    @endauth
                </div>
            </div>

            <div style="grid-column: span 6; display: flex; justify-content: center;">
                <img 
                    src="{{ asset('images/quienesSomos/Nosotros.png') }}?v={{ filemtime(public_path('images/quienesSomos/Nosotros.png')) }}" 
                    alt="Atleta en Iron Pulse" 
                    style="width: 100%; border-radius: 12px; border: 4px solid var(--color-terciario); box-shadow: 0 15px 40px rgba(215, 38, 56, 0.3); object-fit: cover;"
                >
            </div>

        </div>
    </section>

    <section class="bg-terciario" style="padding: 50px 0; border-y: 1px solid rgba(255,255,255,0.1);">
        <div class="container" style="display: flex; justify-content: space-around; text-align: center; flex-wrap: wrap; gap: 30px;">
            <div>
                <h2 class="anton-text text-secundario" style="font-size: 3rem; margin: 0;">24/7</h2>
                <p class="text-secundario" style="margin: 0; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Acceso Total</p>
            </div>
            <div>
                <h2 class="anton-text text-secundario" style="font-size: 3rem; margin: 0;">+50</h2>
                <p class="text-secundario" style="margin: 0; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Máquinas Premium</p>
            </div>
            <div>
                <h2 class="anton-text text-secundario" style="font-size: 3rem; margin: 0;">100%</h2>
                <p class="text-secundario" style="margin: 0; text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">Actitud Iron</p>
            </div>
        </div>
    </section>

    <section id="clases" style="padding: 100px 20px; background-color: #050505;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 class="anton-text text-secundario" style="font-size: 3.5rem; text-transform: uppercase;">Nuestras <span class="text-terciario">Clases</span></h2>
                <div style="width: 80px; height: 4px; background-color: var(--color-terciario); margin: 20px auto;"></div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                
                <div style="background: #111; border: 1px solid #222; border-radius: 8px; overflow: hidden; transition: 0.3s;">
                    <div style="height: 200px; background-image: url('{{ asset('images/clases/Bodybuilding.png') }}'); background-size: cover; background-position: center;"></div>
                    <div style="padding: 25px;">
                        <h3 class="anton-text text-terciario" style="font-size: 1.8rem; margin-bottom: 10px;">BODYBUILDING</h3>
                        <p style="color: #ccc; line-height: 1.5; margin-bottom: 20px;">Zona de peso libre de última generación para esculpir tu físico con la mejor maquinaria del mercado.</p>
                        
                        <div style="display: flex; gap: 20px;">
                            @auth
                                @if(Auth::user()->plan_id)
                                    <a href="{{ route('events.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver clases</a>
                                @else
                                    <a href="{{ route('plans.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver Planes</a>
                                @endif
                            @else
                                <a href="{{ route('plans.index') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver Planes</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div style="background: #111; border: 1px solid #222; border-radius: 8px; overflow: hidden; transition: 0.3s;">
                    <div style="height: 200px; background-image: url('{{ asset('images/clases/PowerLifting.png') }}'); background-size: cover; background-position: center;"></div>
                    <div style="padding: 25px;">
                        <h3 class="anton-text text-terciario" style="font-size: 1.8rem; margin-bottom: 10px;">CROSSFIT</h3>
                        <p style="color: #ccc; line-height: 1.5; margin-bottom: 20px;">WODs diarios diseñados para mejorar tu resistencia, fuerza y agilidad en nuestra zona de boxes.</p>
                        
                        <div style="display: flex; gap: 20px;">
                            @auth
                                @if(Auth::user()->plan_id)
                                    <a href="{{ route('events.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver clases</a>
                                @else
                                    <a href="{{ route('plans.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver Planes</a>
                                @endif
                            @else
                                <a href="{{ route('plans.index') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver Planes</a>
                            @endauth
                        </div>
                    </div>
                </div>

                <div style="background: #111; border: 1px solid #222; border-radius: 8px; overflow: hidden; transition: 0.3s;">
                    <div style="height: 200px; background-image: url('{{ asset('images/clases/Yoga.png') }}'); background-size: cover; background-position: center;"></div>
                    <div style="padding: 25px;">
                        <h3 class="anton-text text-terciario" style="font-size: 1.8rem; margin-bottom: 10px;">POWERLIFTING</h3>
                        <p style="color: #ccc; line-height: 1.5; margin-bottom: 20px;">Plataformas de halterofilia y racks profesionales para los que buscan mover el máximo peso posible.</p>
                        
                        <div style="display: flex; gap: 20px;">
                            @auth
                                @if(Auth::user()->plan_id)
                                    <a href="{{ route('events.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver clases</a>
                                @else
                                    <a href="{{ route('plans.index') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver Planes</a>
                                @endif
                            @else
                                <a href="{{ route('plans.index') }}" class="btn-secondary" style="text-decoration: none; padding: 10px 20px; font-weight: bold; text-transform: uppercase; font-size: 14px;">Ver Planes</a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section id="instalaciones" style="padding: 100px 20px; background-color: #050505;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 class="anton-text text-secundario" style="font-size: 3.5rem; text-transform: uppercase;">
                Nuestras <span class="text-terciario">Instalaciones</span>
            </h2>
            <div style="width: 80px; height: 4px; background-color: var(--color-terciario); margin: 20px auto;"></div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            
            <div style="background: #111; border: 1px solid #222; border-radius: 8px; overflow: hidden;">
                <div style="height: 200px; background-image: url('{{ asset('images/instalaciones/mancuernas.png') }}'); background-size: cover; background-position: center;"></div>
                <div style="padding: 25px;">
                    <h3 class="anton-text text-terciario" style="font-size: 1.8rem; margin-bottom: 10px;">
                        ZONA DE MANCUERNAS
                    </h3>
                    <p style="color: #ccc; line-height: 1.5;">
                        Amplia área de peso libre con mancuernas profesionales para entrenamientos de fuerza y musculación.
                    </p>
                </div>
            </div>

            <div style="background: #111; border: 1px solid #222; border-radius: 8px; overflow: hidden;">
                <div style="height: 200px; background-image: url('{{ asset('images/instalaciones/maquinas.png') }}'); background-size: cover; background-position: center;"></div>
                <div style="padding: 25px;">
                    <h3 class="anton-text text-terciario" style="font-size: 1.8rem; margin-bottom: 10px;">
                        MAQUINARIA PREMIUM
                    </h3>
                    <p style="color: #ccc; line-height: 1.5;">
                        Máquinas de última generación para trabajar todos los grupos musculares de forma segura y eficiente.
                    </p>
                </div>
            </div>

            <div style="background: #111; border: 1px solid #222; border-radius: 8px; overflow: hidden;">
                <div style="height: 200px; background-image: url('{{ asset('images/instalaciones/cardio.png') }}'); background-size: cover; background-position: center;"></div>
                <div style="padding: 25px;">
                    <h3 class="anton-text text-terciario" style="font-size: 1.8rem; margin-bottom: 10px;">
                        ZONA CARDIO
                    </h3>
                    <p style="color: #ccc; line-height: 1.5;">
                        Cintas, bicicletas y elípticas para mejorar tu resistencia y mantener un entrenamiento completo.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
</x-app-layout>