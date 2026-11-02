<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        <div style="width: 100%; max-width: 100%;">
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-secundario text-5xl">MIS RUTINAS</h1>
            </div>

            @if($routines->isEmpty())
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-16 text-center">
                    <p class="text-gray-500">No tienes rutinas aún</p>
                    <a href="{{ route('routines.create') }}" class="btn-primary inline-block mt-5">CREAR PRIMERA RUTINA</a>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; width: 100%;">
                    @foreach($routines as $routine)
                        <div style="background-color: #1a1a1a; border: 1px solid #333; border-radius: 12px; padding: 15px; display: flex; flex-direction: column; min-height: 220px;">
                            <h3 class="text-terciario text-xl mb-3">{{ $routine->name }}</h3>
                            <p class="text-gray-300 mb-5 flex-grow">{{ Str::limit($routine->description, 100) }}</p>
                            <div style="display: flex; gap: 8px; align-items: stretch;">
                                <a href="{{ route('routines.show', $routine) }}" class="btn-secondary text-center no-underline" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 8px 12px; font-size: 0.875rem;">VER</a>
                                <a href="{{ route('routines.edit', $routine) }}" class="btn-secondary text-center no-underline" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 8px 12px; font-size: 0.875rem;">EDITAR</a>
                                <form method="POST" action="{{ route('routines.destroy', $routine) }}" style="flex: 1; display: flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-secondary border-[var(--color-terciario)] text-[var(--color-terciario)]" style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 8px 12px; font-size: 0.875rem;">ELIMINAR</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    <div class="bg-gray-900 border border-gray-600 rounded-xl p-5" style="display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 220px;">
                        <p style="color: #888; margin-bottom: 16px;">Añadir otra rutina</p>
                        <a href="{{ route('routines.create') }}" class="btn-primary" style="padding: 8px 16px;">CREAR RUTINA</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>