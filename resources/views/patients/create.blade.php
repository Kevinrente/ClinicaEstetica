<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo Paciente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <form action="{{ route('patients.store') }}" method="POST" x-data="{ tab: 'basic' }">
                    @csrf
                    
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button type="button" @click="tab = 'basic'"
                                :class="{ 'border-indigo-500 text-indigo-600': tab === 'basic', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'basic' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                📋 Datos Personales
                            </button>

                            <button type="button" @click="tab = 'medical'"
                                :class="{ 'border-red-500 text-red-600': tab === 'medical', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'medical' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                🩺 Historial Médico
                            </button>

                            <button type="button" @click="tab = 'vip'"
                                :class="{ 'border-purple-500 text-purple-600': tab === 'vip', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'vip' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                ✨ Datos VIP
                            </button>
                        </nav>
                    </div>

                    <div class="p-6">
                        
                        <div x-show="tab === 'basic'" x-transition.opacity>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información General</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="first_name" :value="__('Nombres')" />
                                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" required autofocus />
                                </div>
                                <div>
                                    <x-input-label for="last_name" :value="__('Apellidos')" />
                                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" required />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" />
                                </div>
                                <div>
                                    <x-input-label for="phone" :value="__('Teléfono / WhatsApp')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" />
                                </div>
                                <div>
                                    <x-input-label for="birth_date" :value="__('Fecha de Nacimiento')" />
                                    <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" />
                                </div>
                                <div>
                                    <x-input-label for="occupation" :value="__('Ocupación')" />
                                    <x-text-input id="occupation" class="block mt-1 w-full" type="text" name="occupation" placeholder="Ej. Abogada, Estudiante..." />
                                </div>
                            </div>

                            <hr class="my-6 border-gray-200 dark:border-gray-700">
                            
                            <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">En caso de emergencia</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="emergency_contact_name" :value="__('Nombre Contacto')" />
                                    <x-text-input id="emergency_contact_name" class="block mt-1 w-full" type="text" name="emergency_contact_name" />
                                </div>
                                <div>
                                    <x-input-label for="emergency_contact_phone" :value="__('Teléfono Contacto')" />
                                    <x-text-input id="emergency_contact_phone" class="block mt-1 w-full" type="text" name="emergency_contact_phone" />
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'medical'" style="display: none;" x-transition.opacity>
                            <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg mb-6 border border-red-100 dark:border-red-800">
                                <p class="text-sm text-red-600 dark:text-red-400 font-semibold">
                                    ⚠️ Importante: Verifica cuidadosamente antes de procedimientos invasivos.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @php
                                    $conditions = ['Diabetes', 'Hipertensión', 'Marcapasos', 'Alergias', 'Embarazo', 'Problemas Renales', 'Implantes Metálicos', 'Piel Sensible'];
                                @endphp

                                @foreach($conditions as $condition)
                                    <div class="flex items-center">
                                        <input id="cond_{{ $loop->index }}" name="medical_history[{{ $condition }}]" type="checkbox" value="1" 
                                            class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="cond_{{ $loop->index }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $condition }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                <x-input-label for="medical_notes" :value="__('Observaciones Médicas Adicionales')" />
                                <textarea id="medical_notes" name="medical_history[notes]" rows="3" 
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                    placeholder="Detalles sobre alergias o medicamentos..."></textarea>
                            </div>
                        </div>

                        <div x-show="tab === 'vip'" style="display: none;" x-transition.opacity>
                            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg mb-6 flex items-center gap-3">
                                <span class="text-2xl">✨</span>
                                <p class="text-sm text-purple-800 dark:text-purple-300">
                                    Personaliza la experiencia para fidelizar al cliente.
                                </p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">¿Prefieres conversar o silencio?</span>
                                    <div class="flex gap-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="vip_preferences[conversacion]" value="Conversar" class="text-purple-600 focus:ring-purple-500">
                                            <span class="ml-2 dark:text-gray-300">Me gusta conversar</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="vip_preferences[conversacion]" value="Silencio" class="text-purple-600 focus:ring-purple-500">
                                            <span class="ml-2 dark:text-gray-300">Prefiero relajarme en silencio</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bebida Favorita</span>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach(['Agua', 'Café', 'Té', 'Gaseosa'] as $drink)
                                            <label class="inline-flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                                <input type="radio" name="vip_preferences[bebida]" value="{{ $drink }}" class="text-purple-600 focus:ring-purple-500">
                                                <span class="ml-2 dark:text-gray-300">{{ $drink }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="music" :value="__('Género Musical Preferido')" />
                                        <x-text-input id="music" class="block mt-1 w-full" type="text" name="vip_preferences[musica]" placeholder="Ej. Jazz, Pop, Naturaleza..." />
                                    </div>
                                    <div>
                                        <x-input-label for="snack" :value="__('Snack Favorito')" />
                                        <x-text-input id="snack" class="block mt-1 w-full" type="text" name="vip_preferences[snack]" placeholder="Ej. Chocolate, Frutos secos..." />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-200 dark:border-gray-700 rounded-b-lg">
                        <button type="button" class="mr-3 text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 underline">
                            Cancelar
                        </button>
                        <x-primary-button class="ml-3">
                            {{ __('Guardar Paciente') }}
                        </x-primary-button>
                    </div>
                </form>
                </div>
        </div>
    </div>
</x-app-layout>