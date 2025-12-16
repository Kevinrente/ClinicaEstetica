<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Product;

class ServiceController extends Controller
{
    public function index()
    {
        // Obtenemos todos los servicios ordenados por categoría
        $services = Service::orderBy('category')->get();
        return view('services.index', compact('services'));
    }

    public function editRecipe(Service $service)
    {
        // Cargamos todos los productos ordenados alfabéticamente
        $products = Product::orderBy('name')->get();
        
        // Cargamos los productos que YA tiene asignados este servicio (para mostrar los valores actuales)
        // load() es más eficiente que hacer consultas en la vista
        $service->load('products');

        return view('services.recipe', compact('service', 'products'));
    }

    public function updateRecipe(Request $request, Service $service)
    {
        $data = $request->validate([
            'quantities' => 'array',
            'quantities.*' => 'nullable|integer|min:0',
        ]);

        // Preparamos el array para el método sync()
        // El formato que necesita sync es: [product_id => ['quantity' => 2], ...]
        $syncData = [];
        
        if (isset($data['quantities'])) {
            foreach ($data['quantities'] as $productId => $qty) {
                if ($qty > 0) {
                    $syncData[$productId] = ['quantity' => $qty];
                }
            }
        }

        // sync() elimina los que no estén en el array y agrega/actualiza los que sí
        $service->products()->sync($syncData);

        return redirect()->route('services.index')
            ->with('success', 'Receta de insumos actualizada correctamente.');
    }
}