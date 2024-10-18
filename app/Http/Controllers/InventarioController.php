<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Productos::where('Estado', 0)->get();
        return view('Inventario', compact('productos'));
    }

    public function create()
    {
        $categorias = Categorias::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Producto' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:255',
            'Precio' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'Stock' => 'required|integer|min:1',
            'Imagen' => 'nullable|string|max:255',
            'IdCategoria' => 'required|integer',
        ]);

        Productos::create([
            'Producto' => $request->Producto,
            'Descripcion' => $request->Descripcion,
            'Precio' => $request->Precio,
            'Stock' => $request->Stock,
            'Imagen' => $request->Imagen,
            'IdCategoria' => $request->IdCategoria,
            'UsuarioCreacion' => Auth::user()->Usuario,
            'FechaCreacion' => now(),
            'Estado' => 0
        ]);

        return redirect()->route('Inventario')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Productos $producto)
    {
        if ($producto->Estado == 1) {
            return redirect()->route('dashboard');
        }

        $categorias = Categorias::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Productos $producto): RedirectResponse
    {
        $request->validate([
            'Producto' => 'required|string|max:255',
            'Descripcion' => 'required|string|max:255',
            'Precio' => 'required|regex:/^\d+(\.\d{1,2})?$/|min:0',
            'Stock' => 'required|integer|min:1',
            'Imagen' => 'nullable|string|max:255',
            'IdCategoria' => 'required|integer',
        ]);

        $producto->update([
            'Producto' => $request->Producto,
            'Descripcion' => $request->Descripcion,
            'Precio' => $request->Precio,
            'Stock' => $request->Stock,
            'Imagen' => $request->Imagen,
            'IdCategoria' => $request->IdCategoria,
            'UsuarioModificacion' => Auth::user()->Usuario,
            'FechaModificacion' => now(),
            'Estado' => 0
        ]);

        return redirect()->route('Inventario')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Productos $producto): RedirectResponse
    {
        $producto->update([
            'Estado' => 1,
            'UsuarioModificacion' => Auth::user()->Usuario,
            'FechaModificacion' => now(),
        ]);

        return redirect()->route('Inventario')->with('success', 'Producto eliminado exitosamente.');
    }
}
