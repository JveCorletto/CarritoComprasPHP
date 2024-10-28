<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historial de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($compras->isEmpty())
                <p class="text-gray-700 dark:text-gray-300">No tienes compras realizadas aún.</p>
                @else
                @foreach($compras as $compra)
                <div class="mb-6 p-4 border border-gray-700 rounded-md text-white">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Orden: {{ $compra->IdCompra }}</h3>
                        <span>Fecha: {{ $compra->FechaCompra }}</span>
                    </div>

                    @if($compra->comprobanteCompra)
                    <p>Comprobante:
                        <a href="{{ route('obtenerComprobantePaypal', ['captureId' => $compra->comprobanteCompra->TokenPago]) }}">
                            {{ $compra->comprobanteCompra->TokenPago }}
                        </a>
                    </p>
                    @endif


                    <table class="w-full mt-4 border-collapse">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-left p-2">Producto</th>
                                <th class="text-center p-2">Cantidad</th>
                                <th class="text-center p-2">Precio Unitario</th>
                                <th class="text-center p-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compra->detallesCompras as $detalle)
                            <tr class="border-b border-gray-600">
                                <td class="p-2">{{ $detalle->producto->Producto }}</td>
                                <td class="text-center p-2">{{ $detalle->Cantidad }}</td>
                                <td class="text-center p-2">${{ number_format($detalle->PrecioUnitario, 2) }}</td>
                                <td class="text-center p-2">${{ number_format($detalle->SubTotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-end mt-4">
                        <p class="text-lg font-semibold">Total: ${{ number_format($compra->TotalCompra, 2) }}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>