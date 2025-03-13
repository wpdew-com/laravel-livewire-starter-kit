<section class="w-full">
    @include('partials.users-heading')

    <x-settings.user-list>
        <div>
            @can('create permissions')
            <button wire:click="createPermission" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                {{ __('users.Add permission') }}
            </button>
            @endcan


            <div x-data="{ open: @entangle('showForm') }">
                <div x-show="open"
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100] shadow-lg dark:bg-zinc-800 border border-transparent dark:border-zinc-700"
                    style="z-index: 25; background-color: #00000040;">
                    <div class="bg-white p-6 rounded shadow-md w-96">
                        <h2 class="text-lg font-bold mb-4">
                            {{ $permissionId ? __('users.Edit permission') : __('users.Add permission') }}
                        </h2>

                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

                        <form wire:submit.prevent="storePermission">
                            <input type="text" wire:model="name" placeholder="{{ __('users.Name permission') }}"
                                class="border p-2 w-full rounded mb-2">

                            <div class="flex justify-end mt-4">
                                @if($permissionId)
                                    <button wire:click="updatePermission"
                                        class="bg-yellow-500 text-white px-4 py-2 rounded">
                                        {{ __('users.Refresh permission') }}
                                    </button>
                                @else
                                    <button wire:click="storePermission"
                                        class="bg-green-500 text-white px-4 py-2 rounded">
                                        {{ __('users.Create permission') }}
                                    </button>
                                @endif
                                <button x-on:click="open = false" type="button"
                                    class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                    {{ __('users.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(session('message'))
                <x-alert.info>
                    {{ session('message') }}
                </x-alert.info>
            @endif

            <table class="w-full border-collapse border">
                <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">{{ __('users.Name permission') }}</th>
                    <th class="border p-2">{{ __('users.Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($this->permissions() as $permission)
                    <tr class="border">
                        <td class="border p-2">{{ $permission->name }}</td>
                        <td class="border p-2 flex space-x-2">
                            @can('update permissions')
                            <button wire:click="editPermission({{ $permission->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded">
                                ✏️ {{ __('users.Edit permission') }}
                            </button>
                            @endcan
                            @can('delete permissions')
                            <button wire:click="deletePermission({{ $permission->id }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded">
                                🗑 {{ __('users.Delite permission') }}
                            </button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            {{ $this->permissions()->links() }}

        </div>
    </x-settings.user-list>
</section>
