<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agendar Nueva Cita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="patient_id" :value="__('Paciente')" />
                        <select id="patient_id" name="patient_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Seleccione un paciente...</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->full_name }} ({{ $patient->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="service_id" :value="__('Tratamiento / Servicio')" />
                        <select id="service_id" name="service_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Seleccione un servicio...</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->name }} - {{ $service->formatted_price }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label for="start_time" :value="__('Fecha y Hora de Inicio')" />
                        <input type="datetime-local" id="start_time" name="start_time" 
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>

                    <div>
                        <x-input-label for="internal_notes" :value="__('Notas Adicionales (Opcional)')" />
                        <textarea id="internal_notes" name="internal_notes" rows="2" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-primary-button>
                            {{ __('Confirmar Cita') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>