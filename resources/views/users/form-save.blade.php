<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        <img src="image/basket.png" width="100px" alt="">

        </x-slot>
        <h1 class="text-2xl text-black">Save users</h1>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="mr-10 bg-black	">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
