<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="anton-text text-secundario" style="margin: 0;">
                GESTIÓN DE <span class="text-terciario">USUARIOS</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none; font-size: 14px;">
                Volver al Panel
            </a>
        </div>

        @if(session('success'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 4px; margin-bottom: 30px; color: #10b981;">
                ✓ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 15px; border-radius: 8px; margin-bottom: 30px;">
                {{ session('error') }}
            </div>
        @endif
        <div style="margin-bottom: 25px; background-color: #0a0a0a; padding: 15px; border-radius: 10px; border: 1px solid #222;">
            <form method="GET" action="{{ route('admin.users') }}" style="display: flex; gap: 15px; flex-wrap: wrap;">
                
                <div style="flex: 1; min-width: 250px; position: relative;">
                    <span style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #888;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por nombre, correo electrónico o ID..." style="width: 100%; background-color: #111; border: 1px solid #333; color: white; padding: 12px 15px 12px 45px; border-radius: 6px; outline: none; font-family: var(--font-body); transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--color-terciario)'" onblur="this.style.borderColor='#333'">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn-primary" style="border-radius: 6px; padding: 10px 20px;">
                        BUSCAR
                    </button>
                    
                    @if(request('search'))
                        <a href="{{ route('admin.users') }}" class="btn-secondary" style="border-radius: 6px; padding: 10px 20px; display: flex; align-items: center; justify-content: center;">
                            LIMPIAR
                        </a>
                    @endif
                </div>

            </form>
        </div>
        <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    
                    <thead>
                        <tr style="background-color: #0a0a0a; border-bottom: 2px solid var(--color-terciario);">
                            <th style="padding: 15px 20px; color: #aaa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">ID</th>
                            <th style="padding: 15px 20px; color: #aaa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Nombre</th>
                            <th style="padding: 15px 20px; color: #aaa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Email</th>
                            <th style="padding: 15px 20px; color: #aaa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Rol</th>
                            <th style="padding: 15px 20px; color: #aaa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Plan ID</th>
                            <th style="padding: 15px 20px; color: #aaa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #222; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#1a1a1a'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 15px 20px; color: #888; font-weight: bold;">#{{ $user->id }}</td>
                                
                                <td style="padding: 15px 20px; color: #fff; font-weight: 500;">
                                    {{ $user->name }}
                                </td>
                                
                                <td style="padding: 15px 20px; color: #aaa;">{{ $user->email }}</td>
                                
                                <td style="padding: 15px 20px;">
                                    @if($user->role === 'admin')
                                        <span style="background-color: rgba(215, 38, 56, 0.2); color: var(--color-terciario); padding: 4px 10px; border-radius: 50px; font-size: 12px; font-weight: bold; border: 1px solid var(--color-terciario);">STAFF</span>
                                    @else
                                        <span style="background-color: rgba(255, 255, 255, 0.1); color: #ccc; padding: 4px 10px; border-radius: 50px; font-size: 12px;">CLIENTE</span>
                                    @endif
                                </td>

                                <td style="padding: 15px 20px;">
                                    @if($user->plan_id)
                                        <span style="color: #10b981; font-weight: bold;">Plan #{{ $user->plan_id }}</span>
                                    @else
                                        <span style="color: #888;">Sin plan</span>
                                    @endif
                                </td>

                                <td style="padding: 15px 20px; text-align: right;">
                                    <a href="{{ route('admin.users.assign-plan', $user) }}" class="btn-primary" style="padding: 6px 12px; font-size: 12px; border-radius: 4px; text-decoration: none; display: inline-block;">
                                        Asignar / Pagar Plan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</x-app-layout>