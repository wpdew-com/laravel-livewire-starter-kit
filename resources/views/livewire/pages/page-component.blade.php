<section class="w-full">
    @include('partials.page-heading')


<div>

    <!--
    <button wire:click="create">Добавить страницу</button>
-->

    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <x-table>
        <x-slot name="head">
            <x-table.heading>{{ __('pages.ID') }}</x-table.heading>
            <x-table.heading>{{ __('pages.Title') }}</x-table.heading>
            <x-table.heading>{{ __('pages.Actions') }}</x-table.heading>
        </x-slot>
        <x-slot name="body">
            @foreach($pages as $page)
                <x-table.row>
                    <x-table.cell>{{ $page->id }}</x-table.cell>
                    <x-table.cell>{{ $page->title }}</x-table.cell>
                    <x-table.cell>
                        <button wire:click="edit({{ $page->id }})"
                            class="bg-yellow-500 text-white px-2 py-1 rounded">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                        </button>
                        <button wire:click="delete({{ $page->id }})" onclick="return confirm('Удалить?')"
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

    {{ $pages->links() }} <!-- Добавляем пагинацию -->

    @if($isEditMode || $title)
        <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
            <input type="text" wire:model="title" placeholder="Заголовок">
            <textarea wire:model="content" placeholder="Содержание"></textarea>
            <button type="submit">{{ $isEditMode ? 'Обновить' : 'Создать' }}</button>
            <button type="button" wire:click="resetForm">Отмена</button>
        </form>
    @endif


</div>
</section>
