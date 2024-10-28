<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Exception;

class HistorialComprasController extends Controller
{
    public function historialCompras()
    {
        $compras = Compras::with('detallesCompras', 'comprobanteCompra')
            ->where('IdUsuario', Auth::id())
            ->orderBy('FechaCompra', 'desc')
            ->get();

        return view('historial', ['compras' => $compras]);
    }

    public function obtenerComprobantePaypal($captureId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withToken($token)
                ->get("https://api.sandbox.paypal.com/v2/payments/captures/{$captureId}");

            if ($response->successful()) {
                $data = $response->json();
                return view('paypal_comprobante', ['data' => $data]);
            }

            throw new Exception('No se pudo obtener el comprobante de PayPal.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function getAccessToken()
    {
        $clientId = config('paypal.sandbox.client_id');
        $clientSecret = config('paypal.sandbox.client_secret');

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new Exception('No se pudo obtener el token de acceso de PayPal.');
    }
}