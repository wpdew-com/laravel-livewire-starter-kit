<section class="w-full">
    @include('partials.users-heading')

    <x-settings.user-list>

        <div>
            <button wire:click="createRole" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                {{ __('users.Add role') }}
            </button>


            @if(session('message'))
            <x-alert.info>
                {{ session('message') }}
            </x-alert.info>
            @endif

            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('users.Name role') }}</x-table.heading>
                    <x-table.heading>{{ __('users.Permissions') }}</x-table.heading>
                    <x-table.heading>{{ __('users.Actions') }}</x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @foreach ($roles as $role)
                        <x-table.row>
                            <x-table.cell>{{ $role->name }}</x-table.cell>
                            <x-table.cell>
                                {{ implode(', ', $role->permissions->pluck('name')->toArray()) }}
                            </x-table.cell>
                            <x-table.cell>
                                <button wire:click="editRole({{ $role->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $role->id }})"
                                    class="bg-red-500 text-white px-2 py-1 rounded ml-2">
                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot>
            </x-table>


            <!-- Модальное окно -->
            <div x-data="{ open: @entangle('showForm') }">
                <div x-show="open"
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100] shadow-lg dark:bg-zinc-800 border border-transparent dark:border-zinc-700"
                    style="z-index: 25; background-color: #00000040;">
                    <div class="bg-white p-6 rounded shadow-md w-96">
                        <h2 class="text-lg font-bold mb-4">
                            {{ $roleIdToEdit ? __('users.Edit role') : __('users.Add role') }}
                        </h2>

                        <form wire:submit.prevent="storeRole">
                            <input type="text" wire:model="name" placeholder="{{ __('users.Name role') }}"
                                class="border p-2 w-full rounded mb-2">

                            <h3 class="text-sm font-bold mb-2">{{ __('users.Select permissions:') }}</h3>
                            @foreach ($permissions as $permission)
                                <label class="block">
                                    <input type="checkbox" wire:model="selectedPermissions"
                                        value="{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            @endforeach

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    {{ $roleIdToEdit ? __('users.Refresh role') : __('users.Create role') }}
                                </button>
                                <button x-on:click="open = false" type="button"
                                    class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                    {{ __('users.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if($roleIdToDelete)
            <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100] shadow-lg dark:bg-zinc-800 border border-transparent dark:border-zinc-700"
            style="z-index: 25; background-color: #00000040;">
                <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
                    <h3 class="text-lg font-bold mb-2">{{ __('users.Are you sure?') }}</h3>
                    <p class="mb-4">{{ __('users.Deleting a role will result in the loss of all permissions associated with it. Are you sure you want to delete this role?') }}</p>
                    <div class="flex space-x-2">
                        <button wire:click="deleteRole"
                                class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                            Да, удалить
                        </button>
                        <button wire:click="$set('roleIdToDelete', null)"
                                class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                            Отмена
                        </button>
                    </div>
                </div>
            </div>
        @endif




        </div>

    </x-settings.user-list>


</section>
