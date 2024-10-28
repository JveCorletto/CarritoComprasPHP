<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use App\Models\Compras;
use App\Models\DetallesCompras;
use App\Models\ComprobantesCompras;

class PayPalController extends Controller
{
    public function crearPago()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('dashboard')->with('error', 'El carrito está vacío. No hay nada para comprar.');
        }

        // Calcula el total de la compra
        $totalCompra = collect($carrito)->sum(function ($item) {
            return $item['cantidad'] * $item['precio_unitario'];
        });

        // Configurar el cliente de PayPal
        $paypal = new PayPalClient;  // Asegúrate de que PayPalClient esté correctamente implementado
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        // URLs de redirección para el éxito y la cancelación del pago
        $redirectUrls = [
            'return_url' => route('paypal.success'), // Ruta que apunta a capturarPago()
            'cancel_url' => route('paypal.cancel'),  // Ruta para manejar la cancelación del pago
        ];

        // Crear la orden en PayPal
        $response = $paypal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($totalCompra, 2, '.', '')
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => $redirectUrls['return_url'],
                "cancel_url" => $redirectUrls['cancel_url'],
            ]
        ]);

        // Verifica si la orden fue creada exitosamente y redirige a PayPal
        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('dashboard')->with('error', 'No se pudo crear el pago con PayPal.');
    }

    // Dentro del método capturarPago()
    public function capturarPago(Request $request)
    {
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $response = $paypal->capturePaymentOrder($request->get('token'));

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // Crear el comprobante de compra
            $captureId = $response['purchase_units'][0]['payments']['captures'][0]['id'];
            $fechaTransaccion = Carbon::parse($response['purchase_units'][0]['payments']['captures'][0]['create_time'])->format('Y-m-d H:i:s');

            // Obtener el link del comprobante
            $linkComprobante = '';
            foreach ($response['purchase_units'][0]['payments']['captures'][0]['links'] as $link) {
                if ($link['rel'] == 'self') {
                    $linkComprobante = $link['href'];
                    break;
                }
            }

            $comprobante = ComprobantesCompras::create([
                'OrdenCompra' => $response['id'],
                'TokenPago' => $captureId,
                'LinkComprobante' => $linkComprobante,
                'FechaTransaccion' => $fechaTransaccion,
            ]);
            $comprobante->save();

            if ($comprobante) {
                $carrito = session()->get('carrito', []);

                if (!empty($carrito)) {
                    // Crear una nueva compra y asociar el comprobante
                    $compra = Compras::create([
                        'IdEstadoCompra' => 1,
                        'IdUsuario' => Auth::id(),
                        'FechaCompra' => now()->format('Y-m-d'), // Asegúrate de dar el formato correcto a la fecha
                        'TotalCompra' => collect($carrito)->sum(function ($item) {
                            return $item['cantidad'] * $item['precio_unitario'];
                        })
                    ]);

                    $compra->IdComprobante = $comprobante->IdComprobante;
                    $compra->save();

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
        }

        return redirect()->route('dashboard')->with('error', 'Hubo un problema al procesar el pago.');
    }
}
