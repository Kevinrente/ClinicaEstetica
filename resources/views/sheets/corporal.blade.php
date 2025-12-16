<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📏 Ficha Corporal: {{ $appointment->service->name }}
            </h2>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Paciente: {{ $appointment->patient->full_name }}
            </span>
        </div>
    </x-slot>

    <div class="py-12" x-data="corporalSheet()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('clinical-sheets.store', $appointment) }}" method="POST">
                @csrf
                <input type="hidden" name="sheet_type" value="corporal">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2">🧬 Biotipo Corporal</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer border rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition" 
                                       :class="biotype === 'androide' ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : ''">
                                    <input type="radio" name="sheet_data[biotype]" value="androide" x-model="biotype" class="sr-only">
                                    <div class="text-center">
                                        <div class="text-4xl mb-2">🍎</div>
                                        <span class="font-bold text-gray-700 dark:text-gray-200">Androide</span>
                                        <p class="text-xs text-gray-500 mt-1">Grasa en abdomen/espalda</p>
                                    </div>
                                </label>

                                <label class="cursor-pointer border rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                                       :class="biotype === 'ginoide' ? 'ring-2 ring-pink-500 bg-pink-50 dark:bg-pink-900/20' : ''">
                                    <input type="radio" name="sheet_data[biotype]" value="ginoide" x-model="biotype" class="sr-only">
                                    <div class="text-center">
                                        <div class="text-4xl mb-2">🍐</div>
                                        <span class="font-bold text-gray-700 dark:text-gray-200">Ginoide</span>
                                        <p class="text-xs text-gray-500 mt-1">Grasa en cadera/piernas</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2">🟠 Diagnóstico Celulitis</h3>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="sheet_data[celulitis][]" value="Edematosa" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-gray-700 dark:text-gray-300">Edematosa (Retención líquidos)</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="sheet_data[celulitis][]" value="Blanda" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-gray-700 dark:text-gray-300">Blanda (Flacidez asociada)</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="sheet_data[celulitis][]" value="Dura" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-gray-700 dark:text-gray-300">Dura (Compacta/Dolorosa)</span>
                                </label>
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" name="sheet_data[celulitis][]" value="Mixta" class="rounded text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-gray-700 dark:text-gray-300">Mixta</span>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2">⚖️ Peso & IMC</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-700 dark:text-gray-300">Peso (kg)</label>
                                    <input type="number" step="0.1" x-model="weight" name="sheet_data[weight]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-700 dark:text-gray-300">Altura (m)</label>
                                    <input type="number" step="0.01" x-model="height" name="sheet_data[height]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white" placeholder="1.65">
                                </div>
                            </div>
                            <div class="mt-4 p-3 rounded-lg text-center transition-colors" 
                                 :class="imcColor">
                                <span class="block text-xs font-bold uppercase tracking-wide">IMC Calculado</span>
                                <span class="text-2xl font-bold" x-text="imc"></span>
                                <span class="text-sm block" x-text="imcStatus"></span>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 border-b pb-2">📏 Registro de Medidas (cm)</h3>
                            <p class="text-sm text-gray-500 mb-4">Ingresa las medidas de la sesión actual.</p>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Zona Corporal</th>
                                            <th scope="col" class="px-6 py-3">Medida (cm)</th>
                                            <th scope="col" class="px-6 py-3">Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Cintura Alta</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][waist_high]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"><input type="text" class="w-full text-xs border-none bg-transparent" placeholder="Notas..."></td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Cintura Media</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][waist_mid]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Cintura Baja (Ombligo)</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][waist_low]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>
                                        
                                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Cadera</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][hips]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>

                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Brazo Derecho</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][arm_right]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Brazo Izquierdo</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][arm_left]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>

                                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Muslo Derecho</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][thigh_right]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>
                                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b dark:border-gray-700">
                                            <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Muslo Izquierdo</th>
                                            <td class="px-6 py-4"><input type="number" name="sheet_data[measurements][thigh_left]" class="w-24 rounded border-gray-300 dark:bg-gray-900 text-center"></td>
                                            <td class="px-6 py-4"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">⚡ Aparatología / Procedimiento</h3>
                            <textarea name="final_notes" rows="4" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white" placeholder="Ej: Se realizó Hidrolipoclasia con 20ml de solución fisiológica + 30 min de Ultrasonido. Paciente refiere leve molestia."></textarea>
                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('appointments.index') }}" class="mr-4 px-4 py-2 text-gray-600 hover:text-gray-900">Cancelar</a>
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transform transition hover:scale-105">
                                    💾 Guardar Medidas
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function corporalSheet() {
            return {
                biotype: '',
                weight: '',
                height: '',
                
                get imc() {
                    if (this.weight && this.height > 0) {
                        return (this.weight / (this.height * this.height)).toFixed(1);
                    }
                    return '--';
                },

                get imcStatus() {
                    const i = this.imc;
                    if (i === '--') return 'Ingrese datos';
                    if (i < 18.5) return 'Bajo Peso';
                    if (i < 24.9) return 'Peso Normal';
                    if (i < 29.9) return 'Sobrepeso';
                    return 'Obesidad';
                },

                get imcColor() {
                    const s = this.imcStatus;
                    if (s === 'Peso Normal') return 'bg-green-100 text-green-800 border border-green-300';
                    if (s === 'Sobrepeso') return 'bg-orange-100 text-orange-800 border border-orange-300';
                    if (s === 'Obesidad') return 'bg-red-100 text-red-800 border border-red-300';
                    return 'bg-gray-100 text-gray-800';
                }
            }
        }
    </script>
</x-app-layout>