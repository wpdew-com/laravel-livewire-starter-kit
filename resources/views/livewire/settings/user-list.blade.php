<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    // publi call users
    public $users;
    public string $locale = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->users = User::all();
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
};

?>


<section class="w-full">
    @include('partials.users-heading')

    <x-settings.user-list>

        <div>
            @can('create users')
                <x-button.primary wire:click="$set('showForm', true)">
                    {{ __('users.Create') }}
                </x-button.primary>
            @endcan


            @if (session('messageok'))
                <br><br>
                <x-alert.info>
                    {{ session('messageok') }}
                </x-alert.info>
            @endif

            <div x-data="{ open: @entangle('showForm') }">
                <div x-show="open"
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100]"
                    style="z-index: 25; background-color: #00000040;">
                    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
                        <button x-on:click="open = false"
                            class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">
                            ✖
                        </button>

                        <h2 class="text-lg font-bold mb-4 text-center">{{ __('users.create') }}</h2>

                        <form wire:submit.prevent="storeUser">

                            @if (session('error'))
                                <br><br>
                                <x-alert.info>
                                    {{ session('error') }}
                                </x-alert.info>
                            @endif

                            @error('name')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <input type="text" wire:model="name" placeholder="{{ __('users.name') }}"
                                class="border p-2 w-full rounded mb-2">

                            @error('email')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <input type="email" wire:model="email" placeholder="{{ __('users.email') }}"
                                class="border p-2 w-full rounded mb-2">

                            @error('locale')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <select wire:model="locale" class="border p-2 w-full rounded mb-2">
                                <option value="">{{ __('users.Select a locale') }}</option>
                                @foreach ($locales as $locale)
                                    <option value="{{ $locale }}">{{ $locale }}</option>
                                @endforeach
                            </select>

                            @error('password')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <input type="password" wire:model="password" placeholder="{{ __('users.Password') }}"
                                class="border p-2 w-full rounded mb-2">

                            @error('role')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <select wire:model="role" class="border p-2 w-full rounded mb-2">
                                <option value="">{{ __('users.Select a role') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    {{ __('users.create') }}
                                </button>
                                <button type="button" x-on:click="open = false"
                                    class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                    {{ __('users.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <x-table>
                <x-slot name="head">
                    <x-table.heading>{{ __('users.name') }}</x-table.heading>
                    <x-table.heading>{{ __('users.email') }}</x-table.heading>
                    <x-table.heading>{{ __('users.roles') }}</x-table.heading>
                    <x-table.heading>{{ __('users.Actions') }}</x-table.heading>
                </x-slot>


                <x-slot name="body">

                    @foreach ($users as $user)
                        <x-table.row>
                            <x-table.cell>{{ $user->name }}</x-table.cell>
                            <x-table.cell>{{ $user->email }}</x-table.cell>
                            <x-table.cell>{{ $user->role }}</x-table.cell>
                            <!--<x-table.cell>{{ $user->created_at->diffForHumans() }}</x-table.cell>-->
                            <x-table.cell>
                                @can('update users')
                                    <x-button.primary wire:click="editUser({{ $user->id }})">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z" />
                                        </svg>
                                    </x-button.primary>
                                @endcan
                                @can('delete users')
                                    <x-button.danger wire:click="confirmDelete({{ $user->id }})" class="ml-2">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </x-button.danger>
                                @endcan
                            </x-table.cell>
                        </x-table.row>
                    @endforeach
                </x-slot>
            </x-table>

            <div x-data="{ open: @entangle('showConfirm') }">
                <div x-show="open"
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100] shadow-lg dark:bg-zinc-800 border border-transparent dark:border-zinc-700"
                    style="z-index: 25; background-color: #00000040;">
                    <div class="bg-white p-6 rounded shadow-lg w-1/3 relative">
                        <button x-on:click="open = false"
                            class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">
                            ✖
                        </button>
                        <h2 class="text-lg font-bold mb-4 text-center text-red-600">
                            {{ __('users.Are you sure?') }}
                        </h2>
                        <p class="text-center mb-4">
                            {{ __('users.This action cannot be undone!') }}
                        </p>
                        <div class="flex justify-center gap-4">

                            <button wire:click="deleteUser" class="bg-blue-500 text-white px-4 py-2 rounded">
                                {{ __('users.Yes delete') }}
                            </button>
                            <button x-on:click="open = false" class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                {{ __('users.Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{ open: @entangle('showForm') }">
                <div x-show="open"
                    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100]"
                    style="background-color: #00000040;">
                    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
                        <button wire:click="$set('showForm', false)"
                            class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">
                            ✖
                        </button>

                        <h2 class="text-lg font-bold mb-4 text-center">
                            {{ $editMode ? __('users.Edit User') : __('users.Create User') }}
                        </h2>

                        <form wire:submit.prevent="storeUser">
                            @if (session('error'))
                                <x-alert.info>
                                    {{ session('error') }}
                                </x-alert.info>
                            @endif

                            @error('name')
                                <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                            @enderror
                            <input type="text" wire:model="name" placeholder="{{ __('users.name') }}"
                                class="border p-2 w-full rounded mb-2">

                            @error('email')
                                <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                            @enderror
                            <input type="email" wire:model="email" placeholder="{{ __('users.email') }}"
                                class="border p-2 w-full rounded mb-2">

                            @error('locale')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <select wire:model="locale" class="border p-2 w-full rounded mb-2">
                                <option value="">{{ __('users.Select a locale') }}</option>
                                @foreach ($locales as $locale)
                                    <option value="{{ $locale }}">{{ $locale }}</option>
                                @endforeach
                            </select>

                            @if ($editMode)
                                @error('password')
                                    <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                                @enderror
                                <input type="password" wire:model="password"
                                    placeholder="{{ __('users.New Password (optional)') }}"
                                    class="border p-2 w-full rounded mb-2">
                            @else
                                @error('password')
                                    <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                                @enderror
                                <input type="password" wire:model="password"
                                    placeholder="{{ __('users.Password') }}" class="border p-2 w-full rounded mb-2">
                            @endif

                            @error('role')
                                <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                            @enderror
                            <select wire:model="role" class="border p-2 w-full rounded mb-2">
                                <option value="">{{ __('users.Select a role') }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                            <div class="flex justify-end mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">


                                    {{ $editMode ? __('users.Update user') : __('users.Create') }}
                                </button>
                                <button type="button" wire:click="$set('showForm', false)"
                                    class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                    {{ __('users.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

    </x-settings.user-list>

</section>
