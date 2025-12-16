<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📊 Panel de Control: Mimaie Estética
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Ingresos Hoy</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        ${{ number_format($incomeToday, 2) }}
                    </div>
                    <div class="text-xs text-green-600 mt-1">En efectivo y tarjetas</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Citas Hoy</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $appointmentsCount }}
                    </div>
                    <div class="text-xs text-indigo-600 mt-1">Agenda del día</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Por Atender</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $pendingCount }}
                    </div>
                    <div class="text-xs text-orange-600 mt-1">Pacientes en espera</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-gray-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Atendidos</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $completedCount }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Sesiones cerradas</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="space-y-6">
                    
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">⚡ Acciones Rápidas</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('appointments.create') }}" class="flex flex-col items-center justify-center p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition border border-indigo-200 dark:border-indigo-800">
                                <span class="text-2xl mb-2">📅</span>
                                <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300">Nueva Cita</span>
                            </a>
                            <a href="{{ route('patients.create') }}" class="flex flex-col items-center justify-center p-4 bg-pink-50 dark:bg-pink-900/20 rounded-lg hover:bg-pink-100 dark:hover:bg-pink-900/40 transition border border-pink-200 dark:border-pink-800">
                                <span class="text-2xl mb-2">👤</span>
                                <span class="text-sm font-bold text-pink-700 dark:text-pink-300">Nuevo Paciente</span>
                            </a>
                            <a href="{{ route('appointments.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition border border-gray-200 dark:border-gray-600">
                                <span class="text-2xl mb-2">📋</span>
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Ver Agenda</span>
                            </a>
                            <a href="{{ route('services.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition border border-gray-200 dark:border-gray-600">
                                <span class="text-2xl mb-2">💆‍♀️</span>
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Servicios</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-2 -mr-2 w-20 h-20 bg-yellow-400 rounded-full opacity-10 blur-xl"></div>
                        
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            🎂 Cumpleaños (7 Días)
                        </h3>
                        
                        @if($upcomingBirthdays->isEmpty())
                            <p class="text-sm text-gray-500 italic text-center py-4">No hay cumpleaños próximos.</p>
                        @else
                            <ul class="space-y-3">
                                @foreach($upcomingBirthdays as $patient)
                                    <li class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/10 rounded-lg border border-yellow-100 dark:border-yellow-800 transition hover:shadow-sm">
                                        
                                        <div class="flex items-center gap-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center bg-white dark:bg-gray-800 text-xl shadow-sm {{ $patient->isBirthdayToday() ? 'animate-bounce' : '' }}">
                                                {{ $patient->isBirthdayToday() ? '🎉' : '🎁' }}
                                            </div>
                                            
                                            <div>
                                                <a href="{{ route('patients.show', $patient) }}" class="text-sm font-bold text-gray-800 dark:text-white hover:text-indigo-600 hover:underline">
                                                    {{ $patient->full_name }}
                                                </a>
                                                <p class="text-xs text-gray-500">
                                                    Cumple {{ $patient->age + ($patient->isBirthdayToday() ? 0 : 1) }} años
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            @if($patient->isBirthdayToday())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-pink-100 text-pink-800">
                                                    ¡HOY!
                                                </span>
                                            @else
                                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 block">
                                                    {{ $patient->birth_date->format('d M') }}
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>

                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Próximos Turnos</h3>
                    
                    @if($nextAppointments->isEmpty())
                        <div class="text-center py-8 text-gray-500 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                            <p class="mb-2">☕</p>
                            Todo tranquilo. No hay citas pendientes inmediatas.
                        </div>
                    @else
                        <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-700">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha/Hora</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Paciente</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tratamiento</th>
                                        <th class="px-4 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($nextAppointments as $cita)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                            <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                                <div class="flex flex-col">
                                                    <span>{{ $cita->start_time->format('H:i') }}</span>
                                                    <span class="text-xs text-gray-500">{{ $cita->start_time->format('d M') }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                                {{ $cita->patient->full_name }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                                {{ $cita->service->name }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('appointments.attend', $cita) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 font-bold hover:underline">
                                                    Atender →
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>