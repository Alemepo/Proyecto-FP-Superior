<x-app-layout>
    <div style="background-color: var(--color-principal); min-height: 100vh; padding: 40px 20px;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 40px;">
                <h1 class="text-secundario m-0" style="font-size: 48px;">EDITAR RUTINA</h1>
                <a href="{{ route('routines.index') }}" class="btn-secondary" style="text-decoration: none;">← VOLVER</a>
            </div>

            <form method="POST" action="{{ route('routines.update', $routine) }}">
                @csrf
                @method('PUT')
                
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                    <div style="margin-bottom: 20px;">
                        <label class="text-secundario">Nombre *</label>
                        <input type="text" name="name" value="{{ old('name', $routine->name) }}" required class="input">
                    </div>
                    
                    <div>
                        <label class="text-secundario">Descripción</label>
                        <textarea name="description" rows="3" class="input">{{ old('description', $routine->description) }}</textarea>
                    </div>
                </div>
                
                <div style="background-color: #111; border: 1px solid #333; border-radius: 12px; padding: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 class="text-terciario">DÍAS DE ENTRENAMIENTO</h2>
        
                    </div>
                    
                    @php
                        $numDias = old('num_dias', count($routine->exercises ?? []));
                        $diasViejos = old('dias', $routine->exercises ?? []);
                    @endphp
                    
                    <div id="days-container">
                        @for($dia = 0; $dia < $numDias; $dia++)
                            @if($dia > 0)
                                <hr style="border: none; border-top: 2px solid #333; margin: 30px 0;">
                            @endif
                            <div class="day-block bg-gray-900 border border-gray-600 rounded-lg p-5 mb-10">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <h3 class="text-secundario" style="margin: 0;">DÍA {{ $dia + 1 }}</h3>
                                    <button type="button" onclick="removeDay(this)" 
                                        class="btn-danger" style="background-color: var(--color-terciario); padding: 0.25rem 0.75rem; min-width: 40px;">
                                        X
                                    </button>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <input type="text" name="dias[{{ $dia }}][nombre]" 
                                           value="{{ $diasViejos[$dia]['nombre'] ?? '' }}"
                                           placeholder="Nombre del día (ej: Lunes - Pecho)"
                                           class="input">
                                </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-3">
                                    <label class="text-secundario text-xs">EJERCICIOS</label>
                                </div>
                                
                                @php
                                        $numEjercicios = old('num_ejercicios_' . $dia, count($diasViejos[$dia]['ejercicios'] ?? []));
                                        $ejerciciosViejos = $diasViejos[$dia]['ejercicios'] ?? [];
                                @endphp
                                <div class="exercises-container" data-day="{{ $dia }}">
                                    @for($ej = 0; $ej < $numEjercicios; $ej++)
                                        <div class="exercise-grid" style="display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center;">
                                            <input type="text" name="dias[{{ $dia }}][ejercicios][{{ $ej }}][nombre]" 
                                                   value="{{ $ejerciciosViejos[$ej]['nombre'] ?? '' }}"
                                                   placeholder="Ejercicio" style="flex:1 1 220px; min-width:150px;">
                                            <input type="text" name="dias[{{ $dia }}][ejercicios][{{ $ej }}][series]" 
                                                   value="{{ $ejerciciosViejos[$ej]['series'] ?? '' }}"
                                                   placeholder="Series" style="width:80px; min-width:70px;">
                                            <input type="text" name="dias[{{ $dia }}][ejercicios][{{ $ej }}][repeticiones]" 
                                                   value="{{ $ejerciciosViejos[$ej]['repeticiones'] ?? '' }}"
                                                   placeholder="Reps" style="width:80px; min-width:70px;">
                                            <input type="text" name="dias[{{ $dia }}][ejercicios][{{ $ej }}][video_url]" 
                                                   value="{{ $ejerciciosViejos[$ej]['video_url'] ?? '' }}"
                                                   placeholder="URL del Video" style="flex:1 1 180px; min-width:140px;">
                                            <button type="button" onclick="removeExercise(this)" class="btn-danger" style="min-width:40px; padding:0.5rem 0.75rem;">X</button>
                                        </div>
                                    @endfor
                                    <div class="flex justify-center mt-5">
                                        <button type="button" onclick="addExercise({{ $dia }})" class="btn-add">+</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    @endfor

                    <div id="add-day-container" style="display: flex; justify-content: center; margin-top: 40px; margin-bottom: 20px;">
                        <button type="button" onclick="addDay()" 
                            class="btn-add-day" title="Añadir un nuevo día a la rutina">
                            +
                        </button>
                    </div>
                    
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; margin-top: 20px;">ACTUALIZAR RUTINA</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let dayCount = {{ count($diasViejos) }};

        function addDay() {
            dayCount++;
            const container = document.getElementById('days-container');
            const addDayDiv = document.getElementById('add-day-container');
            
            // Agregar HR antes de cada día (excepto el primero)
            if (container.querySelectorAll('.day-block').length > 0) {
                const hr = document.createElement('hr');
                hr.style.cssText = 'border: none; border-top: 2px solid #333; margin: 30px 0;';
                if (addDayDiv) {
                    container.insertBefore(hr, addDayDiv);
                } else {
                    container.appendChild(hr);
                }
            }
            
            const dayBlock = document.createElement('div');
            dayBlock.className = 'day-block bg-gray-900 border border-gray-600 rounded-lg p-5 mb-10';
            dayBlock.innerHTML = `
                <div class="mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="text-secundario" style="margin: 0;">DÍA ${dayCount}</h3>
                    <button type="button" onclick="removeDay(this)" 
                        class="btn-danger" style="background-color: var(--color-terciario); padding: 0.25rem 0.75rem; min-width: 40px;">
                        X
                    </button>
                </div>
                
                <div class="mb-4">
                    <input type="text" name="dias[${dayCount - 1}][nombre]" 
                           placeholder="Nombre del día (ej: Lunes - Pecho)"
                           class="input">
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <label class="text-secundario text-xs">EJERCICIOS</label>
                    </div>
                    
                    <div class="exercises-container" data-day="${dayCount - 1}">
                        <div class="exercise-grid" style="display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center;">
                            <input type="text" name="dias[${dayCount - 1}][ejercicios][0][nombre]" 
                                   placeholder="Ejercicio" style="flex:1 1 220px; min-width:150px;">
                            <input type="text" name="dias[${dayCount - 1}][ejercicios][0][series]" 
                                   placeholder="Series" style="width:80px; min-width:70px;">
                            <input type="text" name="dias[${dayCount - 1}][ejercicios][0][repeticiones]" 
                                   placeholder="Reps" style="width:80px; min-width:70px;">
                            <input type="text" name="dias[${dayCount - 1}][ejercicios][0][video_url]" 
                                   placeholder="URL del Video" style="flex:1 1 180px; min-width:140px;">
                            <button type="button" onclick="removeExercise(this)" class="btn-danger" style="min-width:40px; padding:0.5rem 0.75rem;">X</button>
                        </div>
                        <div class="flex justify-center mt-5">
                            <button type="button" onclick="addExercise(${dayCount - 1})" class="btn-add">+</button>
                        </div>
                    </div>
                </div>
            `;
            if (addDayDiv) {
                container.insertBefore(dayBlock, addDayDiv);
            } else {
                container.appendChild(dayBlock);
            }
        }

        function addExercise(dayIndex) {
            const container = document.querySelector(`.exercises-container[data-day="${dayIndex}"]`);
            const exerciseCount = container.querySelectorAll('.exercise-grid').length;
            const exerciseRow = document.createElement('div');
            exerciseRow.className = 'exercise-grid';
            exerciseRow.style.cssText = 'display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center;';
            exerciseRow.innerHTML = `
                <input type="text" name="dias[${dayIndex}][ejercicios][${exerciseCount}][nombre]" 
                       placeholder="Ejercicio" style="flex:1 1 220px; min-width:150px;">
                <input type="text" name="dias[${dayIndex}][ejercicios][${exerciseCount}][series]" 
                       placeholder="Series" style="width:80px; min-width:70px;">
                <input type="text" name="dias[${dayIndex}][ejercicios][${exerciseCount}][repeticiones]" 
                       placeholder="Reps" style="width:80px; min-width:70px;">
                <input type="text" name="dias[${dayIndex}][ejercicios][${exerciseCount}][video_url]" 
                       placeholder="URL del Video" style="flex:1 1 180px; min-width:140px;">
                <button type="button" onclick="removeExercise(this)" class="btn-danger" style="min-width:40px; padding:0.5rem 0.75rem;">X</button>
            `;
            const addButton = container.querySelector('button[onclick*="addExercise"]');
            if (addButton) {
                container.insertBefore(exerciseRow, addButton.parentElement);
            } else {
                container.appendChild(exerciseRow);
            }
        }

        function removeDay(button) {
            const dayBlock = button.parentElement.parentElement;
            
            // Buscar y eliminar el HR contiguo (antes o después) para mantener la separación correcta
            const prevElement = dayBlock.previousElementSibling;
            if (prevElement && prevElement.tagName === 'HR') {
                prevElement.remove();
            } else {
                const nextElement = dayBlock.nextElementSibling;
                if (nextElement && nextElement.tagName === 'HR') {
                    nextElement.remove();
                }
            }
            
            dayBlock.remove();

            const days = document.querySelectorAll('.day-block');

            days.forEach((day, newIndex) => {
                // actualizar título
                day.querySelector('h3').textContent = `DÍA ${newIndex + 1}`;

                // actualizar inputs - IMPORTANTE: reemplazar TODOS los dias[X] encontrados
                day.querySelectorAll('input').forEach(input => {
                    // Reemplazar todos los dias[X] en el nombre del input
                    input.name = input.name.replace(/dias\[\d+\]/g, `dias[${newIndex}]`);
                });

                // actualizar data-day
                const container = day.querySelector('.exercises-container');
                container.setAttribute('data-day', newIndex);

                // actualizar onclick del botón addExercise
                const addButton = day.querySelector('button[onclick*="addExercise"]');
                if (addButton) {
                    addButton.setAttribute('onclick', `addExercise(${newIndex})`);
                }
                
                // actualizar data-day del contenedor de ejercicios
                const exercisesContainer = day.querySelector('.exercises-container');
                if (exercisesContainer) {
                    exercisesContainer.setAttribute('data-day', newIndex);
                }
            });

            dayCount = days.length;
        }

        function removeExercise(button) {
            button.closest('.exercise-grid').remove();
        }
    </script>
</x-app-layout>
