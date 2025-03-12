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
                        <button wire:click="edit({{ $page->id }})">Редактировать</button>
                        <button wire:click="delete({{ $page->id }})" onclick="return confirm('Удалить?')">Удалить</button>
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
