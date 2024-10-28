<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Comprobante de Pago PayPal') }} - {{ $data['id'] }}
            </h2>

            <a href="{{ route('historial') }}">
                <x-primary-button>{{ __('Volver al Historial') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="https://www.paypalobjects.com/webstatic/icon/pp258.png" alt="PayPal Logo" class="w-16 h-16 mr-4">
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Detalles del Pago</h3>
                    </div>
                    <span class="px-4 py-2 text-lg font-bold rounded-full {{ $data['status'] === 'COMPLETED' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}" style="{{ $data['status'] === 'COMPLETED' ? 'color: #4caf50;' : '' }}">
                        {{ $data['status'] }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información principal -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Información Principal</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID de Captura:</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $data['id'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto:</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $data['amount']['value'] }} {{ $data['amount']['currency_code'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación:</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($data['create_time'])->format('d/m/Y H:i:s') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Información del receptor -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Información del Receptor</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico:</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $data['payee']['email_address'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID del Comerciante:</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $data['payee']['merchant_id'] }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Protección al vendedor -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Protección al Vendedor</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado:</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $data['seller_protection']['status'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Categorías de Disputa:</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">
                                    @foreach($data['seller_protection']['dispute_categories'] as $category)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2 mb-2">{{ $category }}</span>
                                    @endforeach
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Desglose del pago -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                        <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-gray-300">Desglose del Pago</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Bruto:</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    $ {{ $data['seller_receivable_breakdown']['gross_amount']['value'] }} {{ $data['seller_receivable_breakdown']['gross_amount']['currency_code'] }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Comisión de PayPal:</dt>
                                <dd class="text-sm text-red-600 dark:text-red-400">
                                    - $ {{ $data['seller_receivable_breakdown']['paypal_fee']['value'] }} {{ $data['seller_receivable_breakdown']['paypal_fee']['currency_code'] }}
                                </dd>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Neto:</dt>
                                <dd class="text-sm font-bold text-green-600 dark:text-green-400">
                                    $ {{ $data['seller_receivable_breakdown']['net_amount']['value'] }} {{ $data['seller_receivable_breakdown']['net_amount']['currency_code'] }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="https://sandbox.paypal.com/signin" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Ver movimiento en mi cuenta de PayPal
                        <svg class="ml-2 -mr-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>