<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Usuario -->
        <div>
            <x-input-label for="Usuario" :value="__('Usuario')" />
            <x-text-input id="Usuario" class="block mt-1 w-full" type="text" name="Usuario" :value="old('Usuario')" required autofocus />
            <x-input-error :messages="$errors->get('Usuario')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="Contrasenia" :value="__('Contraseña')" />
            <x-text-input id="Contrasenia" class="block mt-1 w-full" type="password" name="Contrasenia" required />
            <x-input-error :messages="$errors->get('Contrasenia')" class="mt-2" />
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li><b>{{ $error }}</b></li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>