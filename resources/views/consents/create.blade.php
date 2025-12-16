<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ✍️ Firmar Consentimiento: {{ $appointment->service->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg p-6">
                
                <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600 h-64 overflow-y-auto">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">TÉRMINOS Y CONDICIONES</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 text-justify">
                        Yo, <strong>{{ $appointment->patient->full_name }}</strong>, con documento de identidad personal, por la presente autorizo al personal de 
                        <strong>Mimaie Estética</strong> a realizar el procedimiento de <strong>{{ $appointment->service->name }}</strong>.
                        <br><br>
                        
                        @if($appointment->service->legal_text)
                            <span class="text-gray-800 dark:text-gray-200 font-medium">
                                {!! nl2br(e($appointment->service->legal_text)) !!}
                            </span>
                        @else
                            Entiendo que este procedimiento puede conllevar riesgos como enrojecimiento, leve inflamación o sensibilidad en la zona tratada.
                            He informado al personal sobre mis condiciones médicas actuales y eximo de responsabilidad al centro.
                        @endif
                        
                        <br><br>
                        Autorizo el uso de fotografías (si aplica) para el historial clínico privado.
                    </p>
                </div>

                <form action="{{ route('consents.store', $appointment) }}" method="POST" id="signature-form">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Por favor, firme en el recuadro:</label>
                        <div class="border-2 border-dashed border-gray-400 rounded-lg flex justify-center bg-white">
                            <canvas id="signature-pad" class="w-full h-48 touch-none"></canvas>
                        </div>
                        <div class="flex justify-between mt-2">
                            <button type="button" id="clear" class="text-xs text-red-500 hover:text-red-700 underline">Borrar y firmar de nuevo</button>
                            <span class="text-xs text-gray-400">Firma Digital Segura</span>
                        </div>
                    </div>

                    <input type="hidden" name="signature" id="signature-input">

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow transition transform hover:scale-105">
                            ✅ Aceptar y Generar PDF
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var canvas = document.getElementById('signature-pad');
            
            // Ajuste responsivo del canvas
            function resizeCanvas() {
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }
            window.onresize = resizeCanvas;
            resizeCanvas();

            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)' // Fondo blanco necesario para el PDF
            });

            document.getElementById('clear').addEventListener('click', function () {
                signaturePad.clear();
            });

            document.getElementById('signature-form').addEventListener('submit', function (e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("Por favor, firme antes de continuar.");
                } else {
                    var dataURL = signaturePad.toDataURL();
                    document.getElementById('signature-input').value = dataURL;
                }
            });
        });
    </script>
</x-app-layout>