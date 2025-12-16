<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                💆‍♀️ Ficha Facial: {{ $appointment->service->name }}
            </h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Paciente: {{ $appointment->patient->full_name }}
            </span>
        </div>
    </x-slot>

    <div class="py-12" x-data="facialSheet()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('clinical-sheets.store', $appointment) }}" method="POST">
                @csrf
                <input type="hidden" name="sheet_type" value="facial">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2">🔍 Análisis Visual</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Textura</label>
                                <select name="sheet_data[texture]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                                    <option>Fina</option>
                                    <option>Media</option>
                                    <option>Gruesa</option>
                                    <option>Asfíctica</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color</label>
                                <select name="sheet_data[color]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                                    <option>Pálido</option>
                                    <option>Sano / Rosado</option>
                                    <option>Rojizo / Eritrosis</option>
                                    <option>Amarillento</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Secreción Sebácea</label>
                                <select name="sheet_data[secretion]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                                    <option>Seca (Alípica)</option>
                                    <option>Normal (Eudérmica)</option>
                                    <option>Mixta</option>
                                    <option>Grasa</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tono Muscular</label>
                                <div class="space-y-2">
                                    <label class="flex items-center"><input type="radio" name="sheet_data[muscle_tone]" value="Bueno" class="text-indigo-600"> <span class="ml-2 text-sm dark:text-gray-300">Buen Contorno</span></label>
                                    <label class="flex items-center"><input type="radio" name="sheet_data[muscle_tone]" value="Flacidez Leve" class="text-indigo-600"> <span class="ml-2 text-sm dark:text-gray-300">Flacidez Leve</span></label>
                                    <label class="flex items-center"><input type="radio" name="sheet_data[muscle_tone]" value="Atonía" class="text-indigo-600"> <span class="ml-2 text-sm dark:text-gray-300">Atonía (Perdido)</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-indigo-600 dark:text-indigo-400 mb-4 border-b pb-2">📋 Protocolo: {{ $appointment->service->name }}</h3>
                            
                            @if($appointment->service->protocol_steps)
                                <div class="space-y-3">
                                    @foreach($appointment->service->protocol_steps as $step)
                                        <label class="flex items-center p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <input type="checkbox" name="sheet_data[protocol_checks][]" value="{{ $step }}" class="w-5 h-5 text-green-600 rounded focus:ring-green-500">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-200">{{ $step }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Este servicio no tiene pasos configurados.</p>
                            @endif
                        </div>
                    </div>

                    <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 flex flex-col items-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2 w-full border-b pb-2">📍 Mapa de Imperfecciones</h3>
                        <p class="text-sm text-gray-500 mb-4 w-full">Selecciona el tipo de lesión y haz clic en el rostro para marcarla.</p>

                        <div class="flex space-x-4 mb-6">
                            <button type="button" @click="markerType = 'acne'" :class="markerType === 'acne' ? 'bg-red-100 ring-2 ring-red-500' : 'bg-gray-100'" class="p-2 rounded-lg flex items-center space-x-2">
                                <span class="w-4 h-4 bg-red-500 rounded-full"></span>
                                <span class="text-sm font-medium text-gray-700">Acné/Pústula</span>
                            </button>
                            <button type="button" @click="markerType = 'mancha'" :class="markerType === 'mancha' ? 'bg-amber-100 ring-2 ring-amber-500' : 'bg-gray-100'" class="p-2 rounded-lg flex items-center space-x-2">
                                <span class="w-4 h-4 bg-amber-900 rounded-full opacity-70"></span>
                                <span class="text-sm font-medium text-gray-700">Mancha/Melasma</span>
                            </button>
                            <button type="button" @click="markerType = 'arruga'" :class="markerType === 'arruga' ? 'bg-blue-100 ring-2 ring-blue-500' : 'bg-gray-100'" class="p-2 rounded-lg flex items-center space-x-2">
                                <span class="w-4 h-1 bg-blue-500"></span>
                                <span class="text-sm font-medium text-gray-700">Arruga/Línea</span>
                            </button>
                            <button type="button" @click="undoLastMarker()" class="text-sm text-gray-500 hover:text-red-500 underline ml-auto">
                                Deshacer último
                            </button>
                        </div>

                        <div class="relative cursor-crosshair border border-gray-200 rounded-lg overflow-hidden" 
                             style="width: 400px; height: 500px;" 
                             @click="addMarker($event)">
                            
                            <svg viewBox="0 0 200 250" class="w-full h-full text-gray-300 bg-gray-50 fill-current">
                                <path d="M100 20 C60 20 30 50 30 100 C30 160 60 220 100 240 C140 220 170 160 170 100 C170 50 140 20 100 20 Z" fill="#f3e5dc" stroke="#dcbba7" stroke-width="2"/>
                                <path d="M60 100 Q70 90 80 100" fill="none" stroke="#a68b7c" stroke-width="2"/>
                                <path d="M120 100 Q130 90 140 100" fill="none" stroke="#a68b7c" stroke-width="2"/>
                                <path d="M100 110 L95 140 L105 140 Z" fill="#e6cbb9"/>
                                <path d="M80 170 Q100 185 120 170" fill="none" stroke="#cc998d" stroke-width="2"/>
                            </svg>

                            <template x-for="(marker, index) in markers" :key="index">
                                <div class="absolute transform -translate-x-1/2 -translate-y-1/2 shadow-sm"
                                     :style="`left: ${marker.x}%; top: ${marker.y}%;`">
                                    
                                    <template x-if="marker.type === 'acne'">
                                        <div class="w-4 h-4 bg-red-500 rounded-full border border-white"></div>
                                    </template>
                                    <template x-if="marker.type === 'mancha'">
                                        <div class="w-6 h-6 bg-amber-900 opacity-50 rounded-full blur-[1px]"></div>
                                    </template>
                                    <template x-if="marker.type === 'arruga'">
                                        <div class="w-8 h-1 bg-blue-500 transform rotate-45"></div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        
                        <input type="hidden" name="sheet_data[face_map]" :value="JSON.stringify(markers)">
                    </div>

                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notas Finales / Recomendaciones para Casa</label>
                    <textarea name="final_notes" rows="3" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white" placeholder="Ej: Paciente sintió ardor leve. Recomiendo crema hidratante noche."></textarea>
                    
                    <div class="mt-4 flex justify-end">
                         <a href="{{ route('appointments.index') }}" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-900">Cancelar</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform transition hover:scale-105">
                            💾 Guardar Ficha y Finalizar Sesión
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        function facialSheet() {
            return {
                markerType: 'acne',
                markers: [],

                addMarker(event) {
                    // Obtener coordenadas relativas a la imagen (en porcentaje)
                    const rect = event.target.getBoundingClientRect();
                    
                    // Si el click fue en un hijo (como el SVG), necesitamos el rect del contenedor padre
                    const container = event.currentTarget; 
                    const containerRect = container.getBoundingClientRect();

                    const x = ((event.clientX - containerRect.left) / containerRect.width) * 100;
                    const y = ((event.clientY - containerRect.top) / containerRect.height) * 100;

                    this.markers.push({
                        x: x.toFixed(2),
                        y: y.toFixed(2),
                        type: this.markerType
                    });
                },

                undoLastMarker() {
                    this.markers.pop();
                }
            }
        }
    </script>
</x-app-layout>