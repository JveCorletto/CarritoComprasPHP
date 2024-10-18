<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Inventario') }}
            </h2>

            <a href="{{ route('productos.create') }}">
                <x-primary-button>{{ __('Agregar Producto') }}</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                <div class="mb-4 p-4 border border-green-200 rounded-md" style="color: while; background-color: #a5d6a7;">
                    {{ session('success') }}
                </div>
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($productos as $producto)
                        <a href="{{ route('productos.edit', ['producto' => $producto->IdProducto]) }}" class="block bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 hover:bg-gray-100 hover:text-black-100 dark:hover:bg-gray-600 dark:hover:text-gray-600">
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4">
                                @if($producto->Imagen)
                                <img src="{{ $producto->Imagen }}" alt="{{ $producto->Producto }}" class="mt-4 w-full h-48 object-contain mx-auto">
                                @endif
                                <h3 class="text-lg font-semibold">{{ $producto->Producto }}</h3>
                                <p class="mt-2">{{ $producto->Descripcion }}</p>
                                <p class="mt-2 font-bold">Precio: ${{ number_format($producto->Precio, 2) }}</p>
                                <p class="mt-2">Stock: {{ $producto->Stock }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>