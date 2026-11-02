<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh; max-width: 1000px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
            <div>
                <h2 class="anton-text text-secundario" style="font-size: 36px; margin: 0;">
                    GESTIÓN DE <span class="text-terciario">PLANES</span>
                </h2>
                <p style="color: #888; margin: 0;">Añade, edita o elimina los planes de membresía.</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none; border-radius: 6px; display: flex; align-items: center;">VOLVER AL PANEL</a>
                <a href="{{ route('admin.plans.create') }}" class="btn-primary" style="text-decoration: none; border-radius: 6px;">+ NUEVO PLAN</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; padding: 15px; border-radius: 4px; margin-bottom: 30px; color: #10b981;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background-color: #1a1a1a; border-bottom: 2px solid #333;">
                        <th style="padding: 15px 20px; color: #888; font-size: 12px; letter-spacing: 1px; width: 50px;">ID</th>
                        <th style="padding: 15px 20px; color: #888; font-size: 12px; letter-spacing: 1px;">NOMBRE</th>
                        <th style="padding: 15px 20px; color: #888; font-size: 12px; letter-spacing: 1px;">PRECIO</th>
                        <th style="padding: 15px 20px; color: #888; font-size: 12px; letter-spacing: 1px; text-align: right;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                        <tr style="border-bottom: 1px solid #222; transition: background 0.2s;" onmouseover="this.style.background='#151515'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px 20px; color: #555;">#{{ $plan->id }}</td>
                            <td style="padding: 15px 20px;">
                                <strong style="color: #fff; display: block; font-size: 16px;">{{ strtoupper($plan->name) }}</strong>
                                <span style="color: #888; font-size: 12px;">{{ Str::limit($plan->description, 50) }}</span>
                            </td>
                            <td style="padding: 15px 20px;">
                                <span style="color: var(--color-terciario); font-weight: bold; font-size: 18px;">{{ number_format($plan->price, 2) }} €</span><span style="color: #888; font-size: 12px;">/mes</span>
                            </td>
                            <td style="padding: 15px 20px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                    <a href="{{ route('admin.plans.edit', $plan) }}" style="color: #fff; background: #333; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; transition: 0.2s;" onmouseover="this.style.background='#444'" onmouseout="this.style.background='#333'">Editar</a>
                                    
                                    <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" style="margin: 0;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este plan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #fff; background: var(--color-terciario); padding: 6px 12px; border: none; border-radius: 4px; font-size: 12px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#b01c2b'" onmouseout="this.style.background='var(--color-terciario)'">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: #666;">
                                No hay planes registrados en la base de datos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
