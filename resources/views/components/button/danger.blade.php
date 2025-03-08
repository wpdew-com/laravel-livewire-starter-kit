<button {{ $attributes->merge(['class' => 'bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700']) }}>
    {{ $slot }}
</button>
