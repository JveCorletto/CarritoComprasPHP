<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre Usuario -->
        <div>
            <x-input-label for="Nombre" :value="__('Nombre')" />
            <x-text-input id="Nombre" class="block mt-1 w-full" type="text" name="Nombre" :value="old('Nombre')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('Nombre')" class="mt-2" />
        </div>

        <!-- Usuario -->
        <div class="mt-4">
            <x-input-label for="Usuario" :value="__('Usuario')" />
            <x-text-input id="Usuario" class="block mt-1 w-full" type="text" name="Usuario" :value="old('Usuario')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('Usuario')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="Contrasenia" :value="__('Contraseña')" />

            <x-text-input id="Contrasenia" class="block mt-1 w-full"
                type="password" name="Contrasenia" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Contrasenia')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <x-input-label for="Contrasenia_confirmation" :value="__('Repita Contraseña')" />

            <x-text-input id="Contrasenia_confirmation" class="block mt-1 w-full"
                type="password" name="Contrasenia_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('Contrasenia_confirmation')" class="mt-2" />
        </div>

        @if ($errors->any())
        <br>
        <div class="alert alert-danger" style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                <li><b>{{ $error }}</b></li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>