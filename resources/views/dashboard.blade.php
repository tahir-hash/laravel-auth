<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1 class="text-center mt-4 mb-2 text-2xl uppercase ">Liste des users</h1>

    {{-- form export --}}
    <form class="flex justify-around mb-5" action="{{ route('export') }}">
        @csrf
        <div>
            <label class="label" for="">Date Debut</label>
            <input type="date" name="dateD" class="input max-w-xs" />
        </div>
        <div>
            <label class="label" for="">Date Fin</label>
            <input type="date" name="dateF" class="input max-w-xs" />
        </div>
        <label class="btn-sm bg-blue-500  hover:bg-sky-700  btn modal-button ">
            Export
        </label>
    </form>
    <div class="flex justify-around">
        <label for="my-modal-4" class="btn-sm bg-blue-500  hover:bg-sky-700  btn modal-button"> @php
            $button = 'Add';
            echo $button;
        @endphp
        </label>
        <!-- The button to open modal -->
        <label for="my-modal-3" class="btn-sm bg-blue-500  hover:bg-sky-700  btn modal-button">Uploads</label>

    </div>

    <!-- Put this part before </body> tag -->
    <input type="checkbox" id="my-modal-3" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box relative">
            <label for="my-modal-3" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <h3 class="text-lg font-bold">Uploads un fichier</h3>
            <form action="{{ route('users.storeUpload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input name='file' type="file" accept=".csv, text/csv" />
                <input type="submit" placeholder="Type here" class="btn" />
            </form>

        </div>
    </div>
    {{-- Ajout et modifier modal --}}
    <input type="checkbox" id="my-modal-4" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box relative">
            <label for="my-modal-4" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
            <h3 class="text-lg font-bold">
                @if ($button == 'Add')
                    {{ __('Save User') }}
                @else
                    {{ __('Update User') }}
                @endif


            </h3>
            <form method="POST">
                @csrf

                <div>
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" required
                        autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                </div>
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms" />

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' =>
                                            '<a target="_blank" href="' .
                                            route('terms.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                            __('Terms of Service') .
                                            '</a>',
                                        'privacy_policy' =>
                                            '<a target="_blank" href="' .
                                            route('policy.show') .
                                            '" class="underline text-sm text-gray-600 hover:text-gray-900">' .
                                            __('Privacy Policy') .
                                            '</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif
                <div class="flex items-center justify-end mt-4">

                    <x-jet-button class="mr-10 bg-black	">
                        {{ __('Register') }}
                    </x-jet-button>
                </div>
            </form>

        </div>
    </div>
    {{-- liste user --}}
    <div class=" mt-4 inline-block min-w-full shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Prenoms et Noms
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Emails
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Created_at
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Actions
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-gray-50 border">
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->email }} </td>
                        <td> {{ $user->created_at->format('d/m/Y') }} </td>

                        <td class="flex">
                            @if ($user->isActivated == true)
                                <label for="my-modal-4"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded btn-left mr-3 ">
                                    Modifier
                                </label>

                                <form class="mr-3" method="post" action="{{ route('delete.user') }}">
                                    @csrf
                                    <input name='archive' type="hidden" value='{{ $user->id }}'>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded btn-left">
                                        Archiver
                                    </button>
                                </form>
                            @endif

                            @if ($user->isActivated == false)
                                <form method="post" action="{{ route('delete.user') }}">
                                    @csrf
                                    <input name='desarchive' type="hidden" value='{{ $user->id }}'>
                                    <button
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded btn-left">
                                        Desarchiver
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links('pagination::tailwind') }}
    </div>
</x-app-layout>
