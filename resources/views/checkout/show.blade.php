<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            💰 Caja: Finalizar Cita
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-8">
                    
                    <div class="text-center mb-8">
                        <h3 class="text-lg text-gray-500 dark:text-gray-400">Total a Pagar por</h3>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white my-2">{{ $appointment->service->name }}</h1>
                        <p class="text-indigo-500 font-semibold">{{ $appointment->patient->full_name }}</p>
                    </div>

                    <form action="{{ route('checkout.process', $appointment) }}" method="POST" x-data="{ method: 'cash', purchaseType: 'single' }">
                        @csrf

                        @if($activePackage)
                            <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="pack" id="use_pack" checked class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <div class="ml-3">
                                        <label for="use_pack" class="block text-sm font-medium text-green-900 dark:text-green-300">
                                            Usar sesión de Pack Activo
                                        </label>
                                        <span class="block text-sm text-green-700 dark:text-green-400">
                                            Le quedan <strong>{{ $activePackage->remaining_sessions }}</strong> sesiones disponibles.
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="package_id" value="{{ $activePackage->id }}">
                            </div>

                            <div class="text-center text-gray-500 my-2">- O -</div>
                        @endif

                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4">
                            
                            @if($appointment->service->sessions_count > 1 && !$activePackage)
                                <div class="flex gap-4 mb-4">
                                    <label class="flex-1 cursor-pointer border rounded-lg p-3 bg-white dark:bg-gray-800" 
                                           :class="purchaseType === 'single' ? 'ring-2 ring-indigo-500' : ''">
                                        <input type="radio" name="purchase_type" value="single" x-model="purchaseType" class="sr-only">
                                        <span class="block text-sm font-bold dark:text-white">Sesión Suelta</span>
                                        <span class="block text-xs text-gray-500">${{ number_format($appointment->service->price / $appointment->service->sessions_count, 2) }} aprox.</span>
                                    </label>
                                    
                                    <label class="flex-1 cursor-pointer border rounded-lg p-3 bg-white dark:bg-gray-800 relative"
                                            :class="purchaseType === 'new_pack' ? 'ring-2 ring-indigo-500' : ''">
                                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-2 py-0.5 rounded-bl-lg">Oferta</span>
                                        <input type="radio" name="purchase_type" value="new_pack" x-model="purchaseType" class="sr-only">
                                        <span class="block text-sm font-bold dark:text-white">Comprar Pack</span>
                                        <span class="block text-xs text-gray-500">{{ $appointment->service->sessions_count }} sesiones por ${{ $appointment->service->price }}</span>
                                    </label>
                                </div>
                            @else
                                <input type="hidden" name="purchase_type" value="single">
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto a Cobrar ($)</label>
                                <input type="number" step="0.01" name="amount" 
                                    :value="purchaseType === 'new_pack' ? '{{ $appointment->service->price }}' : '{{ $appointment->service->price }}'"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-2xl font-bold text-center dark:bg-gray-900 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Método de Pago</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center p-3 border rounded bg-white dark:bg-gray-800">
                                        <input type="radio" name="payment_method" value="Efectivo" checked class="text-indigo-600">
                                        <span class="ml-2 dark:text-white">💵 Efectivo</span>
                                    </label>
                                    <label class="flex items-center p-3 border rounded bg-white dark:bg-gray-800">
                                        <input type="radio" name="payment_method" value="Tarjeta" class="text-indigo-600">
                                        <span class="ml-2 dark:text-white">💳 Tarjeta</span>
                                    </label>
                                    <label class="flex items-center p-3 border rounded bg-white dark:bg-gray-800">
                                        <input type="radio" name="payment_method" value="Transferencia" class="text-indigo-600">
                                        <span class="ml-2 dark:text-white">📱 Transferencia</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow text-lg transition">
                                ✅ Confirmar Pago y Cerrar Cita
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>