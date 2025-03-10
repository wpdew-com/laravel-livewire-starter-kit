<div class="flex items-start max-md:flex-col">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            @can('view users')
            <flux:navlist.item :href="route('settings.user-list')" wire:navigate>{{ __('users.All Users') }}</flux:navlist.item>
            @endcan
            @can('view roles')
            <flux:navlist.item :href="route('settings.role-list')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
            @endcan
            @can('view permissions')
            <flux:navlist.item :href="route('settings.permissions')" wire:navigate>{{ __('Permissions') }}</flux:navlist.item>
            @endcan
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mb-4">
            {{ $actions ?? '' }} {{-- ✅ Выводит слот "actions" --}}
        </div>



        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
