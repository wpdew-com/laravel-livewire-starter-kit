<div class="relative mb-6 w-full">
    <flux:heading size="xl" level="1">{{ __('pages.title') }}</flux:heading>

    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <x-button.nawlist direction="horizontal">
            @can('view page')
            <flux:navlist.item :href="route('dashboard.pages')" wire:navigate>{{ __('pages.All Pages') }}
            </flux:navlist.item>
            @endcan
        </x-button.nawlist>
    </div>

    <flux:separator variant="subtle" />
</div>
