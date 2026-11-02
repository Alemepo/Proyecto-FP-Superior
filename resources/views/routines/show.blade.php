<x-app-layout>
    <div class="bg-[var(--color-principal)] min-h-screen p-10">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 40px;">
                <h1 class="text-secundario text-5xl m-0">{{ $routine->name }}</h1>
                <a href="{{ route('routines.index') }}" class="btn-secondary no-underline">← VOLVER</a>
            </div>

            @if($routine->description)
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-5 mb-8">
                    <p class="text-gray-300">{{ $routine->description }}</p>
                </div>
            @endif

            @foreach($routine->exercises as $dia)
                <div class="bg-gray-900 border border-gray-600 rounded-xl p-5" style="margin-bottom: 40px;">
                    <h2 class="text-terciario text-2xl mb-4">{{ $dia['nombre'] }}</h2>
                    
                    <div style="overflow-x: auto;">
                        <table class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #333;">
                                    <th style="padding: 12px; text-align: left; width: 40%;">Ejercicio</th>
                                    <th style="padding: 12px; text-align: center; width: 20%;">Series</th>
                                    <th style="padding: 12px; text-align: center; width: 20%;">Repeticiones</th>
                                    <th style="padding: 12px; text-align: center; width: 20%;">Video</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dia['ejercicios'] as $ejercicio)
                                    @if($ejercicio['nombre'])
                                        <tr style="border-bottom: 1px solid #222;">
                                            <td style="padding: 12px; text-align: left;">{{ $ejercicio['nombre'] }}</td>
                                            <td style="padding: 12px; text-align: center;">{{ $ejercicio['series'] }}</td>
                                            <td style="padding: 12px; text-align: center;">{{ $ejercicio['repeticiones'] }}</td>
                                            <td style="padding: 12px; text-align: center;">
                                                @if(!empty($ejercicio['video_url']))
                                                    <a href="{{ $ejercicio['video_url'] }}" target="_blank" class="text-terciario underline hover:text-red-400">Ver Video</a>
                                                @else
                                                    <span style="color: #666;">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>