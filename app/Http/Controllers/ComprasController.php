<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use App\Models\Compras;
use App\Models\Productos;
use App\Models\DetallesCompras;

class ComprasController extends Controller
{
    public function index()
    {
        $productos = Productos::where('Estado', 0)->where('Stock', '>', 0)->get();
        return view('dashboard', compact('productos'));
    }

    public function verCarrito()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.ver', compact('carrito'));
    }

    public function agregar(Request $request): RedirectResponse
    {
        // Validar la entrada
        $request->validate([
            'IdProducto' => 'required|exists:productos,IdProducto',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Buscar el producto
        $producto = Productos::find($request->IdProducto);

        // Verificar si hay suficiente stock disponible
        if ($producto->Stock < $request->cantidad) {
            return redirect()->back()->with('error', 'No hay suficiente stock disponible para este producto.');
        }

        // Lógica para agregar el producto al carrito
        $carrito = session()->get('carrito', []);

        // Verificar si el producto ya está en el carrito
        if (isset($carrito[$producto->IdProducto])) {
            $carrito[$producto->IdProducto]['cantidad'] += $request->cantidad;
        } else {
            $carrito[$producto->IdProducto] = [
                'producto' => $producto,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $producto->Precio,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('dashboard')->with('success', 'Producto agregado al carrito exitosamente.');
    }

    public function finalizar(): RedirectResponse
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('dashboard')->with('error', 'No hay productos en el carrito para finalizar la compra.');
        }

        // Crear una nueva compra
        $compra = Compras::create([
            'IdEstadoCompra' => 1,
            'IdUsuario' => Auth::id(),
            'FechaCompra' => now(),
            'TotalCompra' => collect($carrito)->sum(function ($item) {
                return $item['cantidad'] * $item['precio_unitario'];
            }),
        ]);

        // Crear detalles de la compra
        foreach ($carrito as $item) {
            DetallesCompras::create([
                'IdCompra' => $compra->IdCompra,
                'IdProducto' => $item['producto']->IdProducto,
                'Cantidad' => $item['cantidad'],
                'PrecioUnitario' => $item['precio_unitario'],
                'SubTotal' => $item['cantidad'] * $item['precio_unitario'],
            ]);

            // Reducir el stock del producto
            $item['producto']->decrement('Stock', $item['cantidad']);
        }

        // Limpiar el carrito
        session()->forget('carrito');

        return redirect()->route('dashboard')->with('success', 'Compra realizada exitosamente.');
    }
}