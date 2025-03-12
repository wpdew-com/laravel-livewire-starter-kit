@props([
    'variant' => null,
    'direction' => 'vertical' // Значение по умолчанию - 'vertical'
])

@php
$classes = Flux::classes()
    ->add($direction === 'horizontal' ? 'flex flex-row space-x-4 mt-2' : 'flex flex-col')
    ->add('overflow-visible min-h-auto')
    ;
@endphp

<nav {{ $attributes->class($classes) }} data-flux-navlist>
    {{ $slot }}
</nav>
