<section class="w-full">
    @include('partials.users-heading')

    <x-settings.user-list>

        @if(session()->has('message'))
        <div class="bg-green-200 p-2 mb-2 rounded">
            {{ session('message') }}
        </div>
        @endif

        <button wire:click="createPermission" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
            Добавить Разрешение
        </button>



        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Название</th>
                    <th class="border p-2">Действия</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </x-settings.user-list>
</section>
