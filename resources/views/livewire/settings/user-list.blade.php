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

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        // get end mount table $users
        $this->users = User::all();

        // get end mount table $roles

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
            <!-- Кнопка "Добавить пользователя" -->
            <x-button.primary wire:click="$set('showForm', true)">
                {{ __('users.create') }}
            </x-button.primary>




            @if(session('messageok'))
            <br><br>
            <x-alert.info>
                {{ session('messageok') }}
            </x-alert.info>
            @endif


            <!-- Попап окно -->
            <div x-data="{ open: @entangle('showForm') }">
                <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100]" style="z-index: 25; background-color: #00000040;">
             <div class="bg-white p-6 rounded shadow-lg w-full max-w-md relative">
                        <!-- ✅ Ограничение ширины: w-full max-w-md -->

                        <!-- Кнопка закрытия (крестик) -->
                        <button x-on:click="open = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">
                            ✖
                        </button>

                        <h2 class="text-lg font-bold mb-4 text-center">{{ __('users.create') }}</h2>

                        <form wire:submit.prevent="storeUser">
                            <!-- Ошибки теперь занимают всю ширину и переносят текст -->

                            @if(session('error'))
                            <br><br>
                            <x-alert.info>
                                {{ session('error') }}
                            </x-alert.info>
                            @endif

                            @error('name')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <input type="text" wire:model="name" placeholder="{{ __('users.name') }}" class="border p-2 w-full rounded mb-2">

                            @error('email')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <input type="email" wire:model="email" placeholder="{{ __('users.email') }}" class="border p-2 w-full rounded mb-2">

                            @error('password')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <input type="password" wire:model="password" placeholder="{{ __('users.Password') }}" class="border p-2 w-full rounded mb-2">

                            @error('role')
                                <div class="text-red-500 text-sm break-words mb-1">{{ $message }}</div>
                            @enderror
                            <select wire:model="role" class="border p-2 w-full rounded mb-2">
                                <option value="">{{ __('users.Select a role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                            <!-- Кнопки -->
                            <div class="flex justify-end mt-4">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    {{ __('users.create') }}
                                </button>
                                <button type="button" x-on:click="open = false" class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                    {{ __('users.Cancel') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <!-- User List table -->

        <x-table>
            <x-slot name="head">
                <x-table.heading>{{ __('users.name') }}</x-table.heading>
                <x-table.heading>{{ __('users.email') }}</x-table.heading>
                <x-table.heading>{{ __('users.roles') }}</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>


            <x-slot name="body">

                @foreach($users as $user)
                    <x-table.row>
                        <x-table.cell>{{ $user->name }}</x-table.cell>
                        <x-table.cell>{{ $user->email }}</x-table.cell>
                        <x-table.cell>{{ $user->role }}</x-table.cell>
                        <!--<x-table.cell>
                            <x-badge :variant="$user->is_active ? 'success' : 'danger'">
                                {{ $user->is_active ? __('users.active') : __('users.inactive') }}
                            </x-badge>
                        </x-table.cell>-->
                        <x-table.cell>{{ $user->created_at->diffForHumans() }}</x-table.cell>
                        <x-table.cell>
                            <x-button.primary wire:click="editUser({{ $user->id }})">
                                {{ __('Edit') }}
                            </x-button.primary>

                            <x-button.danger wire:click="confirmDelete({{ $user->id }})" class="ml-2">
                                {{ __('Delete') }}
                            </x-button.danger>

                        </x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>


    <!-- Модальное окно подтверждения удаления -->
    <div x-data="{ open: @entangle('showConfirm') }">
        <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100] shadow-lg dark:bg-zinc-800 border border-transparent dark:border-zinc-700" style="z-index: 25; background-color: #00000040;">
            <div class="bg-white p-6 rounded shadow-lg w-1/3 relative">
                <!-- Крестик закрытия -->
                <button x-on:click="open = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl">
                    ✖
                </button>

                <h2 class="text-lg font-bold mb-4 text-center text-red-600">
                    {{ __('users.Are you sure?') }}
                </h2>
                <p class="text-center mb-4">
                    {{ __('users.This action cannot be undone!') }}
                </p>

                <!-- Кнопки -->
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


    </x-settings.user-list>




</section>
