<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Agenda de Citas') }}
            </h2>
            <a href="{{ route('appointments.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                + Nueva Cita
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if($appointments->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            No hay citas programadas próximamente.
                        </div>
                    @else
                        <div class="grid gap-4">
                            @foreach($appointments as $appointment)
                                <div class="flex flex-col md:flex-row items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border-l-4 border-indigo-500 space-y-4 md:space-y-0">
                                    
                                    <div class="flex items-center space-x-4 w-full md:w-auto">
                                        <div class="text-center min-w-[60px]">
                                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $appointment->start_time->format('H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-500 uppercase">
                                                {{ $appointment->start_time->format('M d') }}
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                                                <a href="{{ route('patients.show', $appointment->patient) }}" class="hover:underline hover:text-indigo-800 transition">
                                                    {{ $appointment->patient->full_name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $appointment->service->name }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-3">
                                        <span class="px-3 py-1 text-xs rounded-full {{ $appointment->status_color }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        
                                        @if($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                                            <a href="{{ route('appointments.start', $appointment) }}" 
                                               class="text-sm bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-1 px-3 rounded transition flex items-center">
                                                ▶ <span class="hidden sm:inline ml-1">Atender</span>
                                            </a>
                                        @endif

                                        @if($appointment->payment_status !== 'paid' && $appointment->status !== 'cancelled')
                                            <a href="{{ route('checkout.show', $appointment) }}" 
                                               class="text-sm bg-green-100 hover:bg-green-200 text-green-800 border border-green-300 py-1 px-3 rounded transition flex items-center font-bold">
                                                💰 <span class="hidden sm:inline ml-1">Cobrar</span>
                                            </a>
                                        @elseif($appointment->payment_status === 'paid')
                                            <span class="text-xs font-bold text-green-600 border border-green-600 rounded px-2 py-1 bg-green-50 dark:bg-transparent">
                                                PAGADO
                                            </span>
                                        @endif

                                        @if($appointment->service->requires_consent)
                                            <a href="{{ route('consents.create', $appointment) }}" 
                                            class="text-sm bg-orange-100 hover:bg-orange-200 text-orange-800 border border-orange-300 py-1 px-3 rounded transition flex items-center"
                                            target="_blank"> ✍️ <span class="hidden sm:inline ml-1">Firmar</span>
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>