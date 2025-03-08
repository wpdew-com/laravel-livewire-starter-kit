@livewireStyles
<x-layouts.app.sidebar>
    <flux:main>
        {{ $slot }}
        @livewireScripts
    </flux:main>
</x-layouts.app.sidebar>
