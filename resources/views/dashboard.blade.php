<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1 class="text-center mt-4 mb-2 text-2xl uppercase ">Liste des users</h1>
    <a href="{{ route('users.create') }}">
        <button class="ml-20 mr-0 bg-blue-500	hover:bg-sky-700  text-white font-bold py-2 px-4 rounded btn-left">
            Add
        </button>
    </a>

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
                        Actions
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="bg-gray-50 border">
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->email }} </td>
                        <td class="flex">
                            <form action="{{ route('users.update') }}"class="mr-3">
                              <input type="hidden" name='update' value='{{ $user->id }}'>
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded btn-left">
                                    Modifier
                                </button>
                            </form>
                            <form action="">
                              <input name='update' type="hidden" value='{{ $user->id }}'>
                                <button
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded btn-left">
                                    Archiver
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
