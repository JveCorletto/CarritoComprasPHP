<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Carrito de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(empty($carrito))
                    <p class="text-gray-900 dark:text-gray-100">Tu carrito está vacío.</p>
                    @else
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th class="p-4 text-left">Imagen</th>
                                <th class="p-4 text-left">Producto</th>
                                <th class="p-4 text-left">Cantidad</th>
                                <th class="p-4 text-left">Precio Unitario</th>
                                <th class="p-4 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito as $item)
                            <tr>
                                <td class="p-4"><img height="150" width="150" src="{{ $item['producto']->Imagen }}" alt="{{ $item['producto']->Producto }}"></td>
                                <td class="p-4">{{ $item['producto']->Producto }}</td>
                                <td class="p-4">{{ $item['cantidad'] }}</td>
                                <td class="p-4">${{ number_format($item['precio_unitario'], 2) }}</td>
                                <td class="p-4">${{ number_format($item['cantidad'] * $item['precio_unitario'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <a href="{{ route('paypal.crearPago') }}">
                            <x-secondary-button style="background-color: #198754;">{{ __('Pagar con PayPal') }}</x-secondary-button>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>