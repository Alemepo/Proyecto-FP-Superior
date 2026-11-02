<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh; max-width: 600px;">

        <div style="margin-bottom: 40px; text-align: center;">
            <h2 class="anton-text text-secundario" style="font-size: 36px; margin: 0;">
                EDITAR <span class="text-terciario">PLAN</span>
            </h2>
            <p style="color: #888; margin: 0;">Modifica las características y el precio de #{{ $plan->id }} - {{ strtoupper($plan->name) }}.</p>
        </div>

        <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; padding: 30px;">
            <form method="POST" action="{{ route('admin.plans.update', $plan) }}">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #888; font-size: 12px; margin-bottom: 8px;">NOMBRE DEL PLAN</label>
                    <input type="text" name="name" value="{{ old('name', $plan->name) }}" required style="width: 100%; padding: 12px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none; font-size: 16px;">
                    @error('name')
                        <span style="color: var(--color-terciario); font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #888; font-size: 12px; margin-bottom: 8px;">PRECIO MENSUAL (€)</label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $plan->price) }}" required style="width: 100%; padding: 12px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none; font-size: 16px;">
                    @error('price')
                        <span style="color: var(--color-terciario); font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 30px;">
                    <label style="display: block; color: #888; font-size: 12px; margin-bottom: 8px;">DESCRIPCIÓN / BENEFICIOS</label>
                    <textarea name="description" rows="4" style="width: 100%; padding: 12px; background: #000; border: 1px solid #444; color: #fff; border-radius: 6px; outline: none; resize: vertical; font-size: 14px;">{{ old('description', $plan->description) }}</textarea>
                    @error('description')
                        <span style="color: var(--color-terciario); font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('admin.plans.index') }}" class="btn-secondary" style="text-decoration: none; text-align: center; width: 50%; border-radius: 6px; padding: 12px;">CANCELAR</a>
                    <button type="submit" class="btn-primary" style="width: 50%; border-radius: 6px; padding: 12px; font-weight: bold;">ACTUALIZAR PLAN</button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
