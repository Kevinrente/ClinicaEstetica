<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('stock', 'asc')->get();
        return view('inventory.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return back()->with('success', 'Producto creado correctamente.');
    }

    // Método para agregar stock (Reabastecer)
    public function addStock(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $product->increment('stock', $request->quantity);
        
        return back()->with('success', "Se agregaron {$request->quantity} unidades a {$product->name}");
    }
}