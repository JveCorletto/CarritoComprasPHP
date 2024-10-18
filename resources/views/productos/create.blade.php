<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ingreso de Nuevo Producto') }}
            </h2>

            <a href="{{ route('Inventario') }}">
                <x-secondary-button style="background-color: #198754;">{{ __('Regresar') }}</x-secondary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('productos.store') }}">
                        @csrf

                        <!-- Nombre del Producto y Categoría -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="Producto" :value="__('Nombre del Producto')" />
                                <x-text-input id="Producto" class="block mt-1 w-full" type="text" name="Producto" :value="old('Producto')" required autofocus />
                                <x-input-error :messages="$errors->get('Producto')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="IdCategoria" :value="__('Categoría')" />
                                <select id="IdCategoria" name="IdCategoria" class="block mt-1 w-full rounded-md shadow-sm" style="color: black !important;">
                                <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->IdCategoria }}">{{ $categoria->Categoria }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('IdCategoria')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Descripcion -->
                        <div class="mb-4">
                            <x-input-label for="Descripcion" :value="__('Descripción')" />
                            <x-text-input id="Descripcion" class="block mt-1 w-full" type="text" name="Descripcion" :value="old('Descripcion')" required />
                            <x-input-error :messages="$errors->get('Descripcion')" class="mt-2" />
                        </div>

                        <!-- Precio y Stock -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="Precio" :value="__('Precio')" />
                                <x-text-input id="Precio" class="block mt-1 w-full" type="number" name="Precio" :value="old('Precio')" step="0.01" min="0" required />
                                <x-input-error :messages="$errors->get('Precio')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="Stock" :value="__('Stock')" />
                                <x-text-input id="Stock" class="block mt-1 w-full" type="number" name="Stock" :value="old('Stock')" min="0" required />
                                <x-input-error :messages="$errors->get('Stock')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Imagen -->
                        <div class="mb-4">
                            <x-input-label for="Imagen" :value="__('Imagen (URL)')" />
                            <x-text-input id="Imagen" class="block mt-1 w-full" type="text" name="Imagen" :value="old('Imagen')" oninput="document.getElementById('imagen-preview').src = this.value" />
                            <x-input-error :messages="$errors->get('Imagen')" class="mt-2" />
                            <div class="mt-4">
                                <img id="imagen-preview" src="{{ old('Imagen') }}" alt="Vista previa de la imagen" class="w-48 h-48 object-cover">
                            </div>
                        </div>

                        <x-primary-button class="mt-4">
                            {{ __('Guardar Producto') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>