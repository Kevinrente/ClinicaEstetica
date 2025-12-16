<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🩺 Atender Paciente: {{ $appointment->patient->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">Información</h3>
                        <div class="space-y-3 text-sm">
                            <p><span class="text-gray-500">Servicio:</span> <br> <span class="font-semibold dark:text-white">{{ $appointment->service->name }}</span></p>
                            <p><span class="text-gray-500">Edad:</span> <br> <span class="font-semibold dark:text-white">{{ $appointment->patient->age }} años</span></p>
                            <p><span class="text-gray-500">Ocupación:</span> <br> <span class="font-semibold dark:text-white">{{ $appointment->patient->occupation ?? 'N/A' }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        
                        <form action="{{ route('clinical-sheets.store', $appointment) }}" method="POST">
                            @csrf
                            
                            <input type="hidden" name="sheet_type" value="standard">
                            
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Signos y Síntomas</h3>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="text-xs text-gray-500">Motivo de Consulta</label>
                                    <input type="text" name="sheet_data[reason]" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500">Alergias (Actual)</label>
                                    <input type="text" name="sheet_data[allergies]" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white text-sm">
                                </div>
                            </div>

                            <hr class="my-6 border-gray-200 dark:border-gray-700">

                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                                        📝 Notas de Evolución / Indicaciones
                                    </label>
                                    
                                    <button type="button" id="btn-enhance-ai" 
                                        class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-xs font-bold rounded-full shadow-md transition transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Mejorar con IA
                                    </button>
                                </div>

                                <div class="relative">
                                    <textarea 
                                        name="final_notes" 
                                        id="final_notes" 
                                        rows="6" 
                                        class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:text-white dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                        placeholder="Ej: pte presenta piel deshidratada, se realiza limpieza profunda, recomende hidratacion diaria..."></textarea>
                                    
                                    <div id="ai-loading" class="hidden absolute inset-0 bg-white/90 dark:bg-gray-900/90 flex flex-col items-center justify-center rounded-lg backdrop-blur-sm z-10">
                                        <svg class="animate-spin h-8 w-8 text-indigo-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span class="text-sm font-bold text-indigo-600 animate-pulse">Redactando informe clínico...</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-2">
                                    * La IA convertirá tus apuntes rápidos en un informe médico profesional.
                                </p>
                            </div>

                            <div class="flex justify-end gap-3">
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Cancelar</a>
                                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold shadow hover:shadow-lg transition">
                                    💾 Guardar y Finalizar Cita
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btn-enhance-ai').addEventListener('click', function() {
            const textarea = document.getElementById('final_notes');
            const text = textarea.value;
            const loader = document.getElementById('ai-loading');

            if (text.length < 5) {
                alert('Por favor escribe algunas notas base para que la IA pueda mejorarlas.');
                return;
            }

            loader.classList.remove('hidden');

            fetch('{{ route("ai.enhance") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ text: text })
            })
            .then(response => response.json())
            .then(data => {
                textarea.value = data.text;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al conectar con el servicio de IA.');
            })
            .finally(() => {
                loader.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>