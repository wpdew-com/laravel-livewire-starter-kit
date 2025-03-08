<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('users.locale')" :subheading="__('users.locale_description')">
        <form wire:submit="updateLocale" class="my-6 w-full space-y-6">
            <flux:select wire:model="locale" placeholder="{{ __('users.select_locale') }}" name="locale">
                @foreach($locales as $key => $locale)
                    <flux:select.option value="{{ $key }}">{{ $locale }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('global.save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="locale-updated">
                    {{ __('global.saved') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>

</section>
