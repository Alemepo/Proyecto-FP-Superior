<x-app-layout>
    
        <style>
        /* Quitamos el borde feo por defecto de la librería */
        #reader {
            border: none !important;
            background-color: transparent !important;
        }
        
        /* Forzamos a los botones de la librería a usar nuestro estilo btn-primary */
        #reader button {
            background-color: var(--color-terciario) !important;
            color: var(--color-secundario) !important;
            border: none !important;
            padding: 10px 24px !important;
            border-radius: 6px !important;
            font-family: var(--font-heading) !important;
            font-size: 16px !important;
            text-transform: uppercase !important;
            cursor: pointer !important;
            margin: 10px 5px !important;
            transition: background-color 0.3s ease, transform 0.2s ease !important;
        }

        #reader button:hover {
            background-color: #b01c2b !important;
            transform: translateY(-2px) !important;
        }

        /* Estilo para el enlace de la librería (usando tu color terciario) */
        #reader a {
            color: var(--color-terciario) !important;
            text-decoration: none !important;
            font-size: 14px !important;
            margin-top: 15px !important;
            display: inline-block !important;
            transition: color 0.3s ease !important;
        }

        #reader a:hover {
            color: var(--color-secundario) !important;
        }

        /* Estilo para el selector de cámara de la librería */
        #reader select {
            background-color: #111 !important; /* Fondo oscuro acorde a tu diseño */
            color: var(--color-secundario) !important;
            border: 1px solid #333 !important;
            padding: 10px !important;
            border-radius: 6px !important;
            margin-bottom: 15px !important;
            width: 100% !important;
            max-width: 300px !important;
            font-family: var(--font-body) !important;
        }

        #reader__dashboard_section_csr span {
            color: #ccc !important;
            font-size: 14px !important;
            font-family: var(--font-body) !important;
        }
    </style>

    <div class="container" style="padding-top: 80px; padding-bottom: 60px; max-width: 600px; text-align: center;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="anton-text text-secundario" style="font-size: 32px; margin: 0; text-align: left;">
                CONTROL DE <span class="text-terciario">ACCESOS</span>
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary" style="text-decoration: none; font-size: 14px;">
                Volver al Panel
            </a>
        </div>

        <div style="background-color: #000; padding: 10px; border-radius: 12px; border: 2px solid #333; margin-bottom: 20px;">
            <div id="reader" style="width: 100%; border-radius: 8px; overflow: hidden;"></div>
        </div>

        <div id="result-box" style="display: none; padding: 20px; border-radius: 12px; margin-top: 20px; font-weight: bold;">
            <h3 id="result-title" class="anton-text" style="font-size: 24px; margin-bottom: 5px; color: white;"></h3>
            <p id="result-message" style="color: white; margin: 0;"></p>
        </div>
        
        <button onclick="reiniciarEscaner()" class="btn-primary" style="margin-top: 20px; display: none;" id="btn-reiniciar">
            ESCANEAR SIGUIENTE
        </button>

    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    
    <script>
        let html5QrcodeScanner;

        // Configuramos la cámara
        function iniciarEscaner() {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
            
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }

        // ¿Qué pasa cuando detecta un código?
        function onScanSuccess(decodedText, decodedResult) {
            // Paramos la cámara para que no escanee 20 veces por segundo
            html5QrcodeScanner.clear();

            // Enviamos el código al servidor (Laravel)
            fetch("{{ route('admin.scanner.process') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Seguridad de Laravel
                },
                body: JSON.stringify({ qr_data: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                // Mostramos el resultado por pantalla
                document.getElementById('result-box').style.display = 'block';
                document.getElementById('result-box').style.backgroundColor = data.color;
                document.getElementById('result-title').innerText = data.title;
                document.getElementById('result-message').innerText = data.message;
                
                // Mostramos el botón para escanear a otra persona
                document.getElementById('btn-reiniciar').style.display = 'inline-block';
            });
        }

        function onScanFailure(error) {
            // Ignoramos los errores mientras busca el QR
        }

        function reiniciarEscaner() {
            document.getElementById('result-box').style.display = 'none';
            document.getElementById('btn-reiniciar').style.display = 'none';
            iniciarEscaner();
        }

        // Arrancamos la cámara al cargar la página
        window.onload = iniciarEscaner;
    </script>
</x-app-layout>