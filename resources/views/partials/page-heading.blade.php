<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('pages.title') }}</flux:heading>

    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <x-button.nawlist direction="horizontal">
            @can('view page')
            <flux:navlist.item :href="route('pages')" wire:navigate>{{ __('pages.All Pages') }}
            </flux:navlist.item>
            @endcan
            @can('create page')
                <flux:navlist.item wire:click="create" wire:navigate>{{ __('pages.Add Page') }}</flux:navlist.item>
            @endcan
        </x-button.nawlist>
    </div>

    <flux:separator variant="subtle" />
</div>
