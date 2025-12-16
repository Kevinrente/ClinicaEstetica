<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🗂️ Expediente Digital: {{ $patient->full_name }}
            </h2>
            <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow">
                + Agendar Cita
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 text-center border-t-4 border-indigo-500">
                        <div class="w-24 h-24 bg-indigo-100 rounded-full mx-auto flex items-center justify-center text-3xl mb-4">
                            👤
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $patient->full_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $patient->occupation ?? 'Sin ocupación' }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $patient->phone }}</p>
                        <p class="text-xs text-gray-400 mt-2">Registrado: {{ $patient->created_at->format('d/m/Y') }}</p>
                    </div>

                    @if($patient->vip_preferences)
                    <div class="bg-purple-50 dark:bg-purple-900/20 shadow rounded-lg p-6 border border-purple-100 dark:border-purple-800">
                        <h4 class="font-bold text-purple-800 dark:text-purple-300 mb-3 flex items-center">
                            ✨ Preferencias VIP
                        </h4>
                        <ul class="text-sm space-y-2 dark:text-gray-300">
                            <li><strong>Trato:</strong> {{ $patient->vip_preferences['conversacion'] ?? '--' }}</li>
                            <li><strong>Bebida:</strong> ☕ {{ $patient->vip_preferences['bebida'] ?? '--' }}</li>
                            <li><strong>Música:</strong> 🎵 {{ $patient->vip_preferences['musica'] ?? '--' }}</li>
                            <li><strong>Snack:</strong> 🍪 {{ $patient->vip_preferences['snack'] ?? '--' }}</li>
                        </ul>
                    </div>
                    @endif

                    @if($patient->medical_history)
                    <div class="bg-red-50 dark:bg-red-900/20 shadow rounded-lg p-6 border border-red-100 dark:border-red-800">
                        <h4 class="font-bold text-red-800 dark:text-red-300 mb-3">⚠️ Alertas Médicas</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($patient->medical_history as $key => $val)
                                @if($val == true && $key != 'notes')
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold border border-red-200">
                                        {{ ucfirst($key) }}
                                    </span>
                                @endif
                            @endforeach
                            @if(isset($patient->medical_history['notes']))
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 italic">"{{ $patient->medical_history['notes'] }}"</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6">📜 Historial de Visitas</h3>
                        
                        @if($patient->appointments->isEmpty())
                            <p class="text-gray-500 text-center py-4">No hay historial de visitas aún.</p>
                        @else
                            <div class="relative border-l-2 border-gray-200 dark:border-gray-700 ml-3 space-y-8">
                                @foreach($patient->appointments->sortByDesc('start_time') as $cita)
                                    <div class="relative pl-8">
                                        <span class="absolute top-0 left-[-9px] w-4 h-4 rounded-full border-2 border-white dark:border-gray-800 {{ $cita->status == 'completed' ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                        
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 hover:shadow-md transition">
    
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">
                                                        {{ $cita->start_time->format('d M Y - H:i') }}
                                                    </span>
                                                    <h4 class="text-md font-bold text-gray-800 dark:text-white mt-1">
                                                        {{ $cita->service->name }}
                                                    </h4>
                                                    <span class="text-xs px-2 py-0.5 rounded {{ $cita->status_color }} mt-2 inline-block">
                                                        {{ ucfirst($cita->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="flex flex-col gap-2 text-right">
                                                    @if($cita->clinicalSheet)
                                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">📝 Ficha</span>
                                                    @endif
                                                    @if($cita->consent)
                                                        <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded">📄 Legal</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                @if($cita->photos->count() > 0)
                                                    <p class="text-xs font-bold text-gray-500 mb-2 uppercase">Evidencia Fotográfica</p>
                                                    <div class="flex gap-2 overflow-x-auto pb-2">
                                                        @foreach($cita->photos as $photo)
                                                            <div class="relative flex-shrink-0 group">
                                                                <img src="{{ asset('storage/' . $photo->path) }}" class="h-20 w-20 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-75 transition">
                                                                <span class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-[10px] text-center py-0.5 rounded-b-lg">
                                                                    {{ $photo->type == 'before' ? 'Antes' : 'Después' }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                            <div x-data="{ openUpload: false }">
                                                <button @click="openUpload = !openUpload" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold flex items-center mb-2">
                                                    📷 Subir Foto
                                                </button>

                                                <div x-show="openUpload" style="display: none;" class="bg-white dark:bg-gray-800 p-3 rounded border border-indigo-100 dark:border-gray-600">
                                                    <form action="{{ route('photos.store', $cita) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                                        @csrf
                                                        <select name="type" class="text-xs rounded border-gray-300 dark:bg-gray-900 dark:text-white py-1">
                                                            <option value="before">Antes</option>
                                                            <option value="after">Después</option>
                                                        </select>
                                                        <input type="file" name="photo" class="text-xs text-gray-500 w-full" required>
                                                        <button type="submit" class="bg-indigo-600 text-white px-2 py-1 rounded text-xs hover:bg-indigo-700">Subir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border-t-4 border-green-500">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">🎒 Packs Activos</h3>
                        
                        @if($activePacks->isEmpty())
                            <p class="text-xs text-gray-500">El paciente no tiene packs comprados.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($activePacks as $pack)
                                    <div class="bg-green-50 dark:bg-green-900/20 p-3 rounded-lg border border-green-100 dark:border-green-800">
                                        <p class="text-sm font-bold text-green-800 dark:text-green-300">{{ $pack->service->name }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">Restantes:</span>
                                            <span class="text-lg font-bold text-green-600">{{ $pack->remaining_sessions }} / {{ $pack->total_sessions }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2 dark:bg-gray-700">
                                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ ($pack->remaining_sessions / $pack->total_sessions) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">💰 Últimos Pagos</h3>
                        <div class="space-y-3">
                            @foreach($payments->take(5) as $pay)
                                <div class="flex justify-between items-center text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                                    <div>
                                        <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $pay->concept }}</p>
                                        <p class="text-xs text-gray-500">{{ $pay->created_at->format('d/m - H:i') }} • {{ $pay->method }}</p>
                                    </div>
                                    <span class="font-bold {{ $pay->amount > 0 ? 'text-green-600' : 'text-gray-400' }}">
                                        ${{ number_format($pay->amount, 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>