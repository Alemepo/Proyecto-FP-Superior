<x-app-layout>
    <div class="container" style="padding-top: 100px; padding-bottom: 60px; min-height: 80vh;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; flex-wrap: wrap; gap: 20px;">
            <div>
                <h2 class="anton-text text-secundario" style="margin-bottom: 5px;">
                    CREAR <span class="text-terciario">FICHA DE CLIENTE</span>
                </h2>
                <p style="color: #888; margin: 0;">Registra un nuevo miembro con todos sus datos.</p>
            </div>
            
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none; font-size: 14px;">
                Volver al Panel
            </a>
        </div>

        <div style="background-color: #111; border: 1px solid #333; border-radius: 10px; padding: 30px; max-width: 800px; margin: 0 auto;">

            @if(!$cajaAbierta)
                <div style="background-color: rgba(239, 68, 68, 0.12); border: 1px solid #ef4444; border-radius: 8px; padding: 20px; margin-bottom: 25px; display: flex; align-items: flex-start; gap: 15px;">
                    <div style="font-size: 28px; line-height: 1;"></div>
                    <div>
                        <p style="color: #fca5a5; font-weight: bold; margin: 0 0 5px 0; font-size: 16px;">CAJA CERRADA — No se puede crear la ficha</p>
                        <p style="color: #aaa; margin: 0; font-size: 14px;">Para crear una ficha de cliente es necesario que la caja del día esté abierta, ya que el pago del plan se registra automáticamente. Por favor, abre la caja desde la <a href="{{ route('admin.cash.index') }}" style="color: #ef4444; font-weight: bold;">Gestión de Caja</a> y vuelve aquí.</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" @if(!$cajaAbierta) style="opacity: 0.4; pointer-events: none;" @endif>
                @csrf
                
                <h3 style="color: #fff; margin-bottom: 20px;">Datos Personales</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label for="first_name" style="color: #aaa; font-weight: bold;">Nombre *</label>
                        <input type="text" id="first_name" name="first_name" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="last_name" style="color: #aaa; font-weight: bold;">Apellidos *</label>
                        <input type="text" id="last_name" name="last_name" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="id_type" style="color: #aaa; font-weight: bold;">Tipo de Documento *</label>
                        <select id="id_type" name="id_type" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                            <option value="">Seleccionar</option>
                            <option value="DNI">DNI</option>
                            <option value="NIE">NIE</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div>
                        <label for="id_number" style="color: #aaa; font-weight: bold;">Numero de Documento *</label>
                        <input type="text" id="id_number" name="id_number" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="email" style="color: #aaa; font-weight: bold;">Email *</label>
                        <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="phone" style="color: #aaa; font-weight: bold;">Telefono</label>
                        <input type="tel" id="phone" name="phone" style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="birthdate" style="color: #aaa; font-weight: bold;">Fecha de Nacimiento *</label>
                        <input type="date" id="birthdate" name="birthdate" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff; color-scheme: dark;">
                    </div>
                    <div>
                        <label for="gender" style="color: #aaa; font-weight: bold;">Sexo</label>
                        <select id="gender" name="gender" style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                            <option value="">Seleccionar</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>

                <h3 style="color: #fff; margin-bottom: 20px;">Direccion</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="grid-column: span 2;">
                        <label for="address" style="color: #aaa; font-weight: bold;">Direccion *</label>
                        <input type="text" id="address" name="address" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="country" style="color: #aaa; font-weight: bold;">Pais *</label>
                        <input type="text" id="country" name="country" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="locality" style="color: #aaa; font-weight: bold;">Localidad *</label>
                        <input type="text" id="locality" name="locality" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="province" style="color: #aaa; font-weight: bold;">Provincia *</label>
                        <input type="text" id="province" name="province" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                    <div>
                        <label for="postal_code" style="color: #aaa; font-weight: bold;">Codigo Postal *</label>
                        <input type="text" id="postal_code" name="postal_code" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                </div>

                <h3 style="color: #fff; margin-bottom: 20px;">Contacto de Emergencia</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="grid-column: span 2;">
                        <label for="emergency_contact" style="color: #aaa; font-weight: bold;">Contacto de Emergencia</label>
                        <input type="text" id="emergency_contact" name="emergency_contact" placeholder="Nombre y telefono" style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                    </div>
                </div>

                <h3 style="color: #fff; margin-bottom: 20px;">Membresia</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div>
                        <label for="plan_id" style="color: #aaa; font-weight: bold;">Plan de Membresia *</label>
                        <select id="plan_id" name="plan_id" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                            <option value="">Seleccionar Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} - {{ $plan->price }}€</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="payment_method" style="color: #aaa; font-weight: bold;">Método de Pago en Recepción *</label>
                        <select id="payment_method" name="payment_method" required style="width: 100%; padding: 10px; background-color: #222; border: 1px solid #333; border-radius: 5px; color: #fff;">
                            <option value="">Seleccionar Método</option>
                            <option value="cash">Efectivo</option>
                            <option value="card">Tarjeta</option>
                        </select>
                        <p style="color: #888; font-size: 12px; margin-top: 5px;">Se registrará el ingreso automáticamente en la caja de hoy.</p>
                    </div>
                </div>

                <h3 style="color: #fff; margin-bottom: 20px;">Autorizacion RGPD</h3>
                <div style="margin-bottom: 30px;">
                    <label style="color: #aaa; display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" id="rgpd_consent" name="rgpd_consent" required style="width: 20px; height: 20px;">
                        <span>Acepto el tratamiento de mis datos personales segun la politica de privacidad y RGPD *</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">CREAR FICHA DE CLIENTE</button>
            </form>
        </div>

    </div>

</x-app-layout>




