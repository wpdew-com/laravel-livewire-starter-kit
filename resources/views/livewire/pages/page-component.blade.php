<section class="w-full">
    @include('partials.page-heading')

    <div>

        @can('create page')
        <button wire:click="showForms" class="bg-blue-500 text-white px-4 py-2 rounded">
            {{ __('pages.Add page') }}
        </button> <br> <br>
        @endcan


        @if (session()->has('message'))
            <x-alert.info id="flash-message">
                {{ session('message') }}
            </x-alert.info>
        @endif
        <div id="alertBox"></div>



        <x-table>
            <x-slot name="head">
                <x-table.heading>{{ __('pages.ID') }}</x-table.heading>
                <x-table.heading>{{ __('pages.Title') }}</x-table.heading>
                <x-table.heading>{{ __('pages.Actions') }}</x-table.heading>
            </x-slot>
            <x-slot name="body">
                @foreach ($pages as $page)
                    <x-table.row>
                        <x-table.cell>{{ $page->id }}</x-table.cell>
                        <x-table.cell>{{ $page->title }}</x-table.cell>
                        <x-table.cell>
                            <button wire:click="edit({{ $page->id }})"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">
                                <svg class="w-6 h-6 text-white dark:text-gray-900" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $page->id }})"
                                class="bg-red-500 text-white px-2 py-1 rounded ml-2">
                                <svg class="w-6 h-6 text-white dark:text-gray-900" aria-hidden="true"
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






        <div x-data="{ open: @entangle('showForm') }">
            <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100]"
                style="z-index: 25; background-color: #00000040;">
                <div class="bg-white p-6 rounded shadow-md w-[70rem] max-w-4xl">
                    <h2 class="text-lg font-bold mb-4">
                        {{ $pageId ? __('pages.Edit page') : __('pages.Add page') }}
                    </h2>

                    <form wire:submit.prevent="storePage">

                        @if (session('error'))
                            <x-alert.info>
                                {{ session('error') }}
                            </x-alert.info>
                        @endif

                        <div class="flex flex-wrap gap-4">

                        <div class="w-3/4">
                        <!-- Content -->
                        <div class="mb-5" wire:ignore>
                            <!--
                            <label for="contentEditor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">
                                {{ __('pages.Content') }}
                            </label>
                            -->
                            <textarea id="contentEditor"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="{{ __('pages.Content') }}" required>{!! $content !!}</textarea>
                            @error('content')
                                <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <script>
                        CKEDITOR.on('instanceReady', function (event) {
                            var editor = event.editor;

                            if (editor.notification) {
                                editor.notification.showNotification = function () {};
                            }

                            // Удаляем существующие предупреждения через 500 мс
                            setTimeout(function () {
                                document.querySelectorAll('.cke_notification_warning').forEach(function (el) {
                                    el.remove();
                                });
                            }, 500);
                        });

                            document.addEventListener("DOMContentLoaded", function () {
                                function initEditor() {
                                    if (CKEDITOR.instances.contentEditor) {
                                        CKEDITOR.instances.contentEditor.destroy(); // Удаляем старый экземпляр
                                    }

                                    let editor = CKEDITOR.replace('contentEditor');
                                    editor.setData(@this.get('content')); // Загружаем контент в редактор

                                    editor.on('change', function () {
                                        @this.set('content', editor.getData());
                                    });
                                }

                                document.addEventListener("livewire:load", initEditor);

                                Livewire.on('openEditor', () => {
                                    setTimeout(() => {
                                        initEditor();
                                    }, 300); // Даем время Livewire отрендерить контент
                                });
                            });
                        </script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Livewire.on('clearEditor', () => {
                                    if (CKEDITOR.instances['contentEditor']) {
                                        CKEDITOR.instances['contentEditor'].setData('');
                                    }
                                });
                            });
                        </script>


                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                Livewire.on('flashMessage', message => {
                                    let alertBox = document.getElementById("alertBox");
                                    alertBox.innerHTML = `<div class="bg-green-500 text-white p-2 rounded" style="display:none;">${message}</div>`;
                                    document.body.appendChild(alertBox);

                                    setTimeout(() => {
                                        alertBox.remove();
                                    }, 3000);
                                });
                            });
                        </script>
                         </div>


                        <div class="w-1/4">
                            <!-- Title -->
                            <div class="mb-5">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">
                                    {{ __('pages.Title') }}
                                </label>
                                <input wire:model="title" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="{{ __('pages.Title') }}" required />
                                @error('title')
                                    <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">

                                <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">
                                    {{ __('pages.Uri') }}
                                </label>
                                <input wire:model="slug" type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="{{ __('pages.slug') }}" required />
                                @error('slug')
                                    <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-5" wire:ignore>
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">
                                    {{ __('pages.Description') }}
                                </label>
                                <textarea id="descriptionEditor2" wire:model="description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="{{ __('pages.Description') }}"></textarea>
                                @error('description')
                                    <div class="text-red-500 text-sm mb-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--
                            <div class="mb-5">
                                <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-900">
                                    {{ __('pages.Image') }}
                                </label>
                                <input wire:model="image" type="file"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />


                            </div>
                            -->
                        </div>


                        </div>




                        <!-- Image Upload -->


                        <div class="flex justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                {{ $pageId ? __('pages.Refresh page') : __('pages.Add page') }}
                            </button>
                            <button x-on:click="open = false" wire:click="resetForm" type="button"
                                class="bg-red-500 text-white px-4 py-2 rounded ml-2">
                                {{ __('pages.Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if ($pageIdToDelete)
            <div class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-[100] shadow-lg dark:bg-zinc-800 border border-transparent dark:border-zinc-700"
                style="z-index: 25; background-color: #00000040;">
                <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
                    <h3 class="text-lg font-bold mb-2">{{ __('users.Are you sure?') }}</h3>
                    <p class="mb-4">
                        {{ __('users.Deleting a role will result in the loss of all permissions associated with it. Are you sure you want to delete this role?') }}
                    </p>
                    <div class="flex space-x-2">
                        <button wire:click="deletePage" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                            Да, удалить
                        </button>
                        <button wire:click="$set('isEditMode', null)"
                            class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                            Отмена
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>

</section>
