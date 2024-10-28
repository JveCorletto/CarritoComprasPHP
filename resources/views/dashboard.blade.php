<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModal: false, selectedProduct: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                <div class="mb-4 p-4 border border-green-200 rounded-md" style="color: black; background-color: #a5d6a7;">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 p-4 border border-green-200 rounded-md" style="color: white; background-color: #f44336;">
                    {{ session('error') }}
                </div>
                @endif

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($productos as $producto)
                        <div @click="openModal = true; selectedProduct = {{ json_encode($producto) }}" class="block bg-white dark:bg-gray-700 rounded-lg shadow-md p-4 hover:bg-gray-100 hover:text-black-100 dark:hover:bg-gray-600 dark:hover:text-gray-600 cursor-pointer">
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4">
                                @if($producto->Imagen)
                                <img src="{{ $producto->Imagen }}" alt="{{ $producto->Producto }}" class="mt-4 w-full h-48 object-contain mx-auto">
                                @endif
                                <h3 class="text-lg font-semibold">{{ $producto->Producto }}</h3>
                                <p class="mt-2">{{ $producto->Descripcion }}</p>
                                <p class="mt-2 font-bold">Precio: ${{ number_format($producto->Precio, 2) }}</p>
                                <p class="mt-2">{{ $producto->Stock }} restantes</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="openModal" class="fixed inset-0 z-40 flex items-center justify-center bg-gray-900 bg-opacity-75" x-cloak>
            <!-- Contenedor del Modal -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 z-50">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" x-text="selectedProduct?.Producto"></h3>
                    <button @click="openModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">&times;</button>
                </div>
                <div class="mb-4">
                    <!-- Imagen del Producto -->
                    <img :src="selectedProduct?.Imagen" :alt="selectedProduct?.Producto" class="w-48 h-48 object-contain mx-auto mb-4">
                    <p x-text="selectedProduct?.Descripcion" class="mb-2"></p>
                    <p class="font-bold">Precio: $<span x-text="selectedProduct?.Precio"></span></p>
                    <p>Stock disponible: <span x-text="selectedProduct?.Stock"></span></p>
                </div>
                <form method="POST" action="{{ route('compras.agregar') }}">
                    @csrf
                    <input type="hidden" name="IdProducto" :value="selectedProduct?.IdProducto">
                    <div class="mb-4">
                        <label for="cantidad" class="block font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                        <input id="cantidad" name="cantidad" type="number" min="1" :max="selectedProduct?.Stock" class="block mt-1 w-full" required>
                    </div>
                    <div class="flex justify-end">
                        <x-primary-button type="submit">
                            {{ __('Agregar al Carrito') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>