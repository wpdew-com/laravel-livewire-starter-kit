<table {{ $attributes->merge(['class' => 'border mt-2 w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400']) }}>
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        {{ $head }}
    </thead>
    <tbody>
        {{ $body }}
    </tbody>
</table>
