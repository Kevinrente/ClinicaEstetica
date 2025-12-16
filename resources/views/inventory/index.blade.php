<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            📦 Gestión de Inventario e Insumos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Nuevo Insumo</h3>
                <form action="{{ route('inventory.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 dark:text-gray-300">Nombre del Producto</label>
                        <input type="text" name="name" placeholder="Ej: Jeringa 3ml, Ampolla Vit C" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300">Unidad</label>
                        <select name="unit" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white">
                            <option>Unidad</option>
                            <option>ml</option>
                            <option>Par</option>
                            <option>Gramo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300">Stock Inicial</label>
                        <input type="number" name="stock" placeholder="0" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:text-white" required>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        + Crear
                    </button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Producto</th>
                            <th class="px-6 py-3">Unidad</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Stock Actual</th>
                            <th class="px-6 py-3">Reabastecer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4">{{ $product->unit }}</td>
                                <td class="px-6 py-4">
                                    @if($product->stock <= $product->min_stock)
                                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded border border-red-200">
                                            ⚠️ BAJO STOCK
                                        </span>
                                    @else
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded border border-green-200">
                                            OK
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-bold text-lg {{ $product->stock <= $product->min_stock ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                                    {{ $product->stock }}
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('inventory.add', $product) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="quantity" value="1" min="1" class="w-16 text-xs rounded border-gray-300 dark:bg-gray-900 dark:text-white py-1">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-bold text-lg" title="Agregar">+</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>