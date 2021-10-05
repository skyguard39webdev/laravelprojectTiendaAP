<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('img\aplogo.png') }}" class="logo" alt="AP Importador Logo">
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nombre completo (*)')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Correo Electrónico (*)')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Rol -->
            <div class="mt-4">
                {{-- <x-label for="Rol" :value="__('Rol')" /> --}}

                <x-input id="rol" class="block mt-1 w-full"
                                type="hidden"
                                name="rol"
                                required autocomplete="" 
                                value="2"/>
            </div>


            <!-- telefono -->
            <div class="mt-4">
                <x-label for="telefono" :value="__('Telefono')" />

                <x-input id="telefono" class="block mt-1 w-full"
                                type="text"
                                name="telefono"
                                required autocomplete="new-telefono" />
            </div>


            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña (*)')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirmar Contraseña (*)')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya tiene cuenta?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
